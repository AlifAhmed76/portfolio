<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Page;
use App\Models\PageTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::with(['template', 'revisions' => fn($q) => $q->select('id', 'page_id', 'revision_number')])
            ->withCount('revisions')
            ->latest()
            ->paginate(15);

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        $templates = PageTemplate::all();
        return view('admin.pages.create', compact('templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'page_template_id' => 'nullable|exists:page_templates,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $slug = Str::slug($validated['slug'] ?: $validated['title']);

        // Check uniqueness in workspace
        $exists = Page::where('slug', $slug)->exists();
        if ($exists) {
            $slug .= '-' . Str::random(4);
        }

        $initialBlocks = [];
        if (!empty($validated['page_template_id'])) {
            $template = PageTemplate::find($validated['page_template_id']);
            if ($template && !empty($template->schema_json)) {
                $initialBlocks = $template->schema_json;
            }
        }

        $page = Page::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'page_template_id' => $validated['page_template_id'] ?? null,
            'content_json' => $initialBlocks,
            'status' => 'draft',
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        ActivityLog::log('pages.created', ['title' => $page->title, 'slug' => $page->slug]);

        return redirect()->route('admin.pages.builder', $page)
            ->with('success', "Page '{$page->title}' created. Ready for visual layout editing.");
    }

    public function edit(Page $page): View
    {
        $templates = PageTemplate::all();
        return view('admin.pages.edit', compact('page', 'templates'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'page_template_id' => 'nullable|exists:page_templates,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
        ]);

        $page->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'page_template_id' => $validated['page_template_id'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? ($page->published_at ?? now()) : null,
            'updated_by' => auth()->id(),
        ]);

        ActivityLog::log('pages.updated', ['title' => $page->title]);

        return redirect()->route('admin.pages.index')
            ->with('success', "Page '{$page->title}' updated successfully.");
    }

    public function destroy(Page $page): RedirectResponse
    {
        $title = $page->title;
        $page->delete();

        ActivityLog::log('pages.deleted', ['title' => $title]);

        return redirect()->route('admin.pages.index')
            ->with('success', "Page '{$title}' was deleted successfully.");
    }
}
