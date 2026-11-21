<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HomepageSection;
use App\Services\CacheInvalidationService;
use App\Services\WorkspaceResolver;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionController extends Controller
{
    protected array $defaultSections = [
        ['section_key' => 'hero', 'title' => 'Hero Banner', 'sort_order' => 1],
        ['section_key' => 'highlights', 'title' => 'Professional Highlights', 'sort_order' => 2],
        ['section_key' => 'about', 'title' => 'About Alif Ahmed', 'sort_order' => 3],
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
        $workspace = WorkspaceResolver::resolve();

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

    public function update(Request $request, HomepageSection $section): RedirectResponse
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

        return back()->with('success', "Section '{$section->title}' updated successfully.");
    }

    public function toggle(HomepageSection $section): RedirectResponse
    {
        $section->update(['is_enabled' => ! $section->is_enabled]);
        CacheInvalidationService::invalidateSections();

        return back()->with('success', "Section '{$section->title}' visibility toggled.");
    }
}
