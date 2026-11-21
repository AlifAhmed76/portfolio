<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\ThemeResolver;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        protected ThemeResolver $themeResolver
    ) {}

    public function show(string $slug, Request $request): View
    {
        // Reserved paths guard
        if (in_array(strtolower($slug), ['admin', 'api', 'projects', 'blog', 'contact', 'media', 'storage', 'build', 'up'], true)) {
            abort(404);
        }

        $query = Page::where('slug', $slug);

        // If not logged in as admin, require published status
        if (! auth()->check() || auth()->user()->role !== 'owner') {
            $query->where('status', 'published')->whereNotNull('published_at');
        }

        $page = $query->firstOrFail();
        $theme = ThemeResolver::resolve();
        $blocks = $page->getBlocks();

        // Theme custom template check
        $viewName = "themes.{$theme->slug}.pages.page";
        if (! view()->exists($viewName)) {
            $viewName = 'themes.crystal-3d.pages.page';
        }

        return view($viewName, [
            'page' => $page,
            'blocks' => $blocks,
            'theme' => $theme,
        ]);
    }
}
