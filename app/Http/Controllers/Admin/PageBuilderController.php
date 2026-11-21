<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Page;
use App\Models\PageRevision;
use App\Services\PageBuilderService;
use App\Services\ThemeResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageBuilderController extends Controller
{
    public function __construct(
        protected PageBuilderService $builderService,
        protected ThemeResolver $themeResolver
    ) {}

    public function builder(Page $page): View
    {
        $page->load('revisions');
        $availableBlocks = $this->builderService->getAvailableBlockDefinitions();
        $blocks = $page->getBlocks();

        return view('admin.pages.builder', compact('page', 'availableBlocks', 'blocks'));
    }

    public function saveDraft(Request $request, Page $page): JsonResponse
    {
        $blocks = $request->input('blocks', []);
        if (is_string($blocks)) {
            $blocks = json_decode($blocks, true) ?? [];
        }

        try {
            $this->builderService->saveDraft($page, $blocks, auth()->id());
            ActivityLog::log('pages.draft_saved', ['page_id' => $page->id, 'title' => $page->title]);

            return response()->json([
                'success' => true,
                'message' => 'Draft saved successfully.',
                'status' => $page->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function publish(Request $request, Page $page): JsonResponse
    {
        $blocks = $request->input('blocks', []);
        if (is_string($blocks)) {
            $blocks = json_decode($blocks, true) ?? [];
        }

        try {
            $publishedPage = $this->builderService->publish($page, $blocks, auth()->id());
            ActivityLog::log('pages.published', ['page_id' => $page->id, 'title' => $page->title]);

            return response()->json([
                'success' => true,
                'message' => 'Page published successfully with snapshot revision created.',
                'status' => $publishedPage->status,
                'published_at' => $publishedPage->published_at?->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function revisions(Page $page): JsonResponse
    {
        $revisions = PageRevision::where('page_id', $page->id)
            ->with('creator:id,name,email')
            ->orderByDesc('revision_number')
            ->get();

        return response()->json([
            'success' => true,
            'revisions' => $revisions,
        ]);
    }

    public function restoreRevision(Page $page, int $revisionNumber): RedirectResponse
    {
        try {
            $this->builderService->restoreRevision($page, $revisionNumber, auth()->id());
            ActivityLog::log('pages.restored', ['page_id' => $page->id, 'revision' => $revisionNumber]);

            return redirect()->route('admin.pages.builder', $page)
                ->with('success', "Revision #{$revisionNumber} restored successfully.");
        } catch (\Exception $e) {
            return redirect()->route('admin.pages.builder', $page)
                ->with('error', "Unable to restore revision: {$e->getMessage()}");
        }
    }

    public function preview(Page $page, Request $request): View
    {
        $activeTheme = ThemeResolver::resolve();
        $blocks = $page->getBlocks();

        return view('admin.pages.preview-frame', [
            'page' => $page,
            'blocks' => $blocks,
            'theme' => $activeTheme,
        ]);
    }
}
