<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Models\ThemeRevision;
use App\Models\WorkspaceTheme;
use App\Services\ThemePublishingService;
use App\Services\ThemeResolver;
use App\Services\WorkspaceResolver;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ThemeController extends Controller
{
    public function __construct(protected ThemePublishingService $publishingService)
    {
    }

    public function index(): View
    {
        $this->syncThemeCatalog();

        $workspaceId = WorkspaceResolver::currentId();
        $themes = Theme::where('status', 'active')->get();
        $activeTheme = ThemeResolver::resolve();

        $activeWorkspaceTheme = WorkspaceTheme::where('workspace_id', $workspaceId)
            ->where('is_active', true)
            ->first();

        $revisions = ThemeRevision::with(['theme', 'creator'])
            ->where('workspace_id', $workspaceId)
            ->latest('id')
            ->limit(10)
            ->get();

        return view('admin.themes.index', compact('themes', 'activeTheme', 'activeWorkspaceTheme', 'revisions'));
    }

    public function preview(Theme $theme): RedirectResponse
    {
        $token = $this->publishingService->generatePreviewToken($theme);

        return redirect(url('/?theme_preview=' . $token));
    }

    public function publish(Request $request, Theme $theme): RedirectResponse
    {
        try {
            $customSettings = $request->input('tokens');
            $this->publishingService->publish($theme, $customSettings);

            return redirect()->route('admin.themes.index')->with('success', "Theme '{$theme->name}' has been successfully published and set as the active theme.");
        } catch (Exception $e) {
            return redirect()->route('admin.themes.index')->with('error', $e->getMessage());
        }
    }

    public function rollback(ThemeRevision $revision): RedirectResponse
    {
        try {
            $this->publishingService->rollback($revision);

            return redirect()->route('admin.themes.index')->with('success', "Successfully rolled back to Revision #{$revision->revision_number} for theme '{$revision->theme->name}'.");
        } catch (Exception $e) {
            return redirect()->route('admin.themes.index')->with('error', $e->getMessage());
        }
    }

    protected function syncThemeCatalog(): void
    {
        $themeDirs = File::directories(resource_path('views/themes'));

        foreach ($themeDirs as $dir) {
            $manifestPath = $dir . '/theme.json';
            if (File::exists($manifestPath)) {
                $manifest = json_decode(File::get($manifestPath), true);
                if (is_array($manifest) && isset($manifest['slug'], $manifest['name'])) {
                    Theme::updateOrCreate(
                        ['slug' => $manifest['slug']],
                        [
                            'name' => $manifest['name'],
                            'version' => $manifest['version'] ?? '1.0.0',
                            'manifest_json' => $manifest,
                            'status' => 'active',
                        ]
                    );
                }
            }
        }
    }
}
