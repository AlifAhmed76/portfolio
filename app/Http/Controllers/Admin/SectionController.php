<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HomepageSection;
use App\Services\CacheInvalidationService;
use App\Services\WorkspaceResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionController extends Controller
{
    protected array $defaultSections = [
        ['section_key' => 'hero', 'title' => 'Hero Banner', 'sort_order' => 1],
        ['section_key' => 'highlights', 'title' => 'Professional Highlights', 'sort_order' => 2],
        ['section_key' => 'about', 'title' => 'About Me', 'sort_order' => 3],
        ['section_key' => 'expertise', 'title' => 'Technical Expertise & Skills', 'sort_order' => 4],
        ['section_key' => 'projects', 'title' => 'Featured Projects & Case Studies', 'sort_order' => 5],
        ['section_key' => 'services', 'title' => 'Services & Solutions', 'sort_order' => 6],
        ['section_key' => 'experience', 'title' => 'Professional Experience', 'sort_order' => 7],
        ['section_key' => 'education', 'title' => 'Education & Credentials', 'sort_order' => 8],
        ['section_key' => 'process', 'title' => 'Working Process', 'sort_order' => 9],
        ['section_key' => 'blog', 'title' => 'Latest Insights & Articles', 'sort_order' => 10],
        ['section_key' => 'contact', 'title' => 'Get in Touch', 'sort_order' => 11],
    ];

    public function index(): View
    {
        $workspace = WorkspaceResolver::current();

        // Ensure default sections exist
        foreach ($this->defaultSections as $sec) {
            HomepageSection::firstOrCreate(
                ['workspace_id' => $workspace?->id, 'section_key' => $sec['section_key']],
                ['title' => $sec['title'], 'sort_order' => $sec['sort_order'], 'is_enabled' => true]
            );
        }

        $sections = HomepageSection::orderBy('sort_order')->get();

        return view('admin.sections.index', compact('sections'));
    }

    public function reorder(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'order' => ['nullable', 'array'],
            'order.*.id' => ['required_with:order', 'integer'],
            'order.*.sort_order' => ['required_with:order', 'integer'],
            'ids' => ['nullable', 'array'],
            'ids.*' => ['integer'],
        ]);

        if ($request->has('order')) {
            foreach ($request->input('order') as $item) {
                HomepageSection::where('id', $item['id'])->update(['sort_order' => (int) $item['sort_order']]);
            }
        } elseif ($request->has('ids')) {
            foreach ($request->input('ids') as $index => $id) {
                HomepageSection::where('id', $id)->update(['sort_order' => $index + 1]);
            }
        }

        ActivityLog::log('section.reorder', ['count' => count($request->input('order', $request->input('ids', [])))]);
        CacheInvalidationService::invalidateSections();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Homepage sections reordered successfully.',
            ]);
        }

        return back()->with('success', 'Homepage sections reordered successfully.');
    }

    public function update(Request $request, HomepageSection $section): JsonResponse|RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer'],
            'is_enabled' => ['boolean'],
        ]);

        $section->update([
            'title' => $request->title,
            'sort_order' => $request->sort_order,
            'is_enabled' => $request->boolean('is_enabled'),
        ]);

        ActivityLog::log('section.update', ['section_key' => $section->section_key], $section);
        CacheInvalidationService::invalidateSections();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Section '{$section->title}' updated successfully.",
                'section' => $section,
            ]);
        }

        return back()->with('success', "Section '{$section->title}' updated successfully.");
    }

    public function toggle(HomepageSection $section): JsonResponse|RedirectResponse
    {
        $section->update(['is_enabled' => ! $section->is_enabled]);
        CacheInvalidationService::invalidateSections();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_enabled' => (bool) $section->is_enabled,
                'message' => "Section '{$section->title}' visibility set to " . ($section->is_enabled ? 'Active' : 'Inactive') . '.',
            ]);
        }

        return back()->with('success', "Section '{$section->title}' visibility toggled.");
    }
}
