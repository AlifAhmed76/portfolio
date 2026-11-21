<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Models\Theme;
use App\Models\ThemeSetting;
use App\Models\WorkspaceTheme;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\View;

class ThemeResolver
{
    protected static ?Theme $resolvedTheme = null;
    protected static ?string $previewSlug = null;

    public static function setPreviewSlug(?string $slug): void
    {
        static::$previewSlug = $slug;
        static::$resolvedTheme = null;
    }

    public static function resolve(): Theme
    {
        // 1. Check for request preview token dynamically FIRST
        $previewToken = request()?->query('theme_preview') ?? session('theme_preview_token');
        if ($previewToken) {
            try {
                $payload = Crypt::decrypt($previewToken);
                if (is_array($payload) && isset($payload['slug'], $payload['expires_at'])) {
                    if (now()->timestamp <= $payload['expires_at']) {
                        $previewTheme = Theme::where('slug', $payload['slug'])->first();
                        if ($previewTheme) {
                            return $previewTheme;
                        }
                    }
                }
            } catch (\Exception $e) {
                // Invalid or tampered token, fall through to normal resolution
            }
        }

        if (static::$previewSlug) {
            $previewTheme = Theme::where('slug', static::$previewSlug)->first();
            if ($previewTheme) {
                return $previewTheme;
            }
        }

        if (static::$resolvedTheme !== null) {
            return static::$resolvedTheme;
        }

        // 2. Resolve active theme from workspace
        $workspaceId = WorkspaceResolver::currentId();
        if ($workspaceId) {
            $activeRelation = WorkspaceTheme::where('workspace_id', $workspaceId)
                ->where('is_active', true)
                ->with('theme')
                ->first();

            if ($activeRelation && $activeRelation->theme) {
                static::$resolvedTheme = $activeRelation->theme;
                return static::$resolvedTheme;
            }
        }

        // 3. Fallback to site settings or default crystal-3d
        $slug = SiteSetting::get('active_theme', 'crystal-3d');
        $theme = Theme::where('slug', $slug)->first();

        if (! $theme) {
            $theme = Theme::firstOrCreate(
                ['slug' => 'crystal-3d'],
                [
                    'name' => 'Crystal 3D',
                    'version' => '1.0.0',
                    'manifest_json' => [
                        'slug' => 'crystal-3d',
                        'name' => 'Crystal 3D',
                        'mode' => 'dark-first',
                        'tokens' => [
                            'accent_color' => '#10b981',
                            'surface_blur' => '16px',
                            'border_opacity' => '0.15',
                        ],
                    ],
                    'status' => 'active',
                ]
            );
        }

        static::$resolvedTheme = $theme;
        return static::$resolvedTheme;
    }

    public static function getView(string $viewPath): string
    {
        $theme = static::resolve();
        $themeView = "themes.{$theme->slug}.{$viewPath}";

        if (View::exists($themeView)) {
            return $themeView;
        }

        // Fallback to crystal-3d baseline if not found in active theme
        $fallbackView = "themes.crystal-3d.{$viewPath}";
        if (View::exists($fallbackView)) {
            return $fallbackView;
        }

        return $viewPath;
    }

    public static function getTokens(): array
    {
        $theme = static::resolve();
        $manifestTokens = $theme->manifest_json['tokens'] ?? [];

        $workspaceId = WorkspaceResolver::currentId();
        $customSetting = ThemeSetting::where('workspace_id', $workspaceId)
            ->where('theme_id', $theme->id)
            ->first();

        $customTokens = $customSetting?->settings_json ?? [];

        return array_merge([
            'accent_color' => '#10b981',
            'font_heading' => 'Plus Jakarta Sans',
            'font_body' => 'Inter',
            'radius' => '0.75rem',
        ], $manifestTokens, $customTokens);
    }

    public static function clear(): void
    {
        static::$resolvedTheme = null;
        static::$previewSlug = null;
    }
}
