<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\SiteSetting;
use App\Models\Theme;
use App\Models\ThemeRevision;
use App\Models\ThemeSetting;
use App\Models\User;
use App\Models\WorkspaceTheme;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use InvalidArgumentException;

class ThemePublishingService
{
    public function validate(Theme $theme): array
    {
        $errors = [];
        $slug = $theme->slug;

        // 1. Validate manifest
        $manifest = $theme->manifest_json;
        if (! is_array($manifest)) {
            $errors[] = "Theme '{$slug}' is missing a valid JSON manifest.";
        } else {
            if (empty($manifest['name'])) {
                $errors[] = "Theme manifest must contain a 'name'.";
            }
            if (empty($manifest['version'])) {
                $errors[] = "Theme manifest must specify 'version'.";
            }
        }

        // 2. Validate required view files exist
        $requiredViews = [
            'layouts/app',
            'pages/home',
            'pages/projects/index',
            'pages/projects/show',
        ];

        foreach ($requiredViews as $view) {
            $dotPath = str_replace('/', '.', $view);
            $fullView = "themes.{$slug}.{$dotPath}";
            if (! View::exists($fullView)) {
                $errors[] = "Required template '{$fullView}' does not exist.";
            }
        }

        return $errors;
    }

    public function generatePreviewToken(Theme $theme, ?User $user = null, int $lifetimeMinutes = 60): string
    {
        $userId = $user?->id ?? Auth::id();

        $payload = [
            'slug' => $theme->slug,
            'theme_id' => $theme->id,
            'user_id' => $userId,
            'expires_at' => now()->addMinutes($lifetimeMinutes)->timestamp,
        ];

        return Crypt::encrypt($payload);
    }

    public function publish(Theme $theme, ?array $customSettings = null): void
    {
        $validationErrors = $this->validate($theme);
        if (! empty($validationErrors)) {
            throw new InvalidArgumentException('Cannot publish theme due to validation failures: '.implode('; ', $validationErrors));
        }

        $workspaceId = WorkspaceResolver::currentId();
        if (! $workspaceId) {
            throw new InvalidArgumentException('No active workspace resolved for theme publication.');
        }

        DB::transaction(function () use ($theme, $customSettings, $workspaceId) {
            $previousActive = WorkspaceTheme::where('workspace_id', $workspaceId)
                ->where('is_active', true)
                ->first();

            $previousSlug = $previousActive?->theme?->slug ?? 'none';

            // 1. Deactivate current active theme
            WorkspaceTheme::where('workspace_id', $workspaceId)->update(['is_active' => false]);

            // 2. Activate target theme
            $workspaceTheme = WorkspaceTheme::updateOrCreate(
                ['workspace_id' => $workspaceId, 'theme_id' => $theme->id],
                ['is_active' => true, 'activated_at' => now()]
            );

            // 3. Update theme settings if passed
            if ($customSettings !== null) {
                ThemeSetting::updateOrCreate(
                    ['workspace_id' => $workspaceId, 'theme_id' => $theme->id],
                    ['settings_json' => $customSettings, 'updated_by' => Auth::id()]
                );
            }

            // 4. Record Theme Revision
            $currentSetting = ThemeSetting::where('workspace_id', $workspaceId)
                ->where('theme_id', $theme->id)
                ->first();

            $revisionNum = (ThemeRevision::where('workspace_id', $workspaceId)
                ->where('theme_id', $theme->id)
                ->max('revision_number') ?? 0) + 1;

            ThemeRevision::create([
                'workspace_id' => $workspaceId,
                'theme_id' => $theme->id,
                'revision_number' => $revisionNum,
                'settings_snapshot' => $currentSetting?->settings_json ?? $theme->manifest_json['tokens'] ?? [],
                'created_by' => Auth::id(),
                'created_at' => now(),
            ]);

            // 5. Update site setting reference
            SiteSetting::set('active_theme', $theme->slug);

            // 6. Security audit logging
            ActivityLog::log('theme.publish', [
                'theme' => $theme->slug,
                'previous_theme' => $previousSlug,
                'revision' => $revisionNum,
            ]);

            // 7. Clear theme resolver static cache and all public render caches
            ThemeResolver::clear();
            CacheInvalidationService::invalidateAll();
        });
    }

    public function rollback(ThemeRevision $revision): void
    {
        $workspaceId = $revision->workspace_id;
        $theme = $revision->theme;

        DB::transaction(function () use ($revision, $workspaceId, $theme) {
            // Restore snapshot
            ThemeSetting::updateOrCreate(
                ['workspace_id' => $workspaceId, 'theme_id' => $theme->id],
                ['settings_json' => $revision->settings_snapshot, 'updated_by' => Auth::id()]
            );

            // Activate theme
            WorkspaceTheme::where('workspace_id', $workspaceId)->update(['is_active' => false]);
            WorkspaceTheme::updateOrCreate(
                ['workspace_id' => $workspaceId, 'theme_id' => $theme->id],
                ['is_active' => true, 'activated_at' => now()]
            );

            SiteSetting::set('active_theme', $theme->slug);

            ActivityLog::log('theme.rollback', [
                'theme' => $theme->slug,
                'restored_revision' => $revision->revision_number,
            ]);

            ThemeResolver::clear();
            CacheInvalidationService::invalidateAll();
        });
    }
}
