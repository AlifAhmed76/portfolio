<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Models\ActivityLog;
use App\Models\Media;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectDetail;
use App\Models\ProjectLink;
use App\Models\Skill;
use App\Services\CacheInvalidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::with(['category', 'coverImage'])->latest('sort_order')->latest('id');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $projects = $query->paginate(15)->withQueryString();
        $categories = ProjectCategory::orderBy('name')->get();

        return view('admin.projects.index', compact('projects', 'categories'));
    }

    public function create(): View
    {
        $categories = ProjectCategory::orderBy('name')->get();
        $skills = Skill::with('category')->orderBy('sort_order')->get();
        $mediaImages = Media::where('mime_type', 'like', 'image/%')->latest()->get();

        return view('admin.projects.create', compact('categories', 'skills', 'mediaImages'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $project = Project::create([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'category_id' => $validated['category_id'] ?? null,
                'summary' => $validated['summary'] ?? null,
                'description' => $validated['description'] ?? null,
                'cover_image_id' => $validated['cover_image_id'] ?? null,
                'status' => $validated['status'],
                'is_featured' => $validated['is_featured'] ?? false,
                'sort_order' => $validated['sort_order'] ?? 0,
                'published_at' => ($validated['status'] === 'published') ? now() : null,
            ]);

            // Case study detail
            ProjectDetail::create([
                'project_id' => $project->id,
                'challenge' => $validated['challenge'] ?? null,
                'solution' => $validated['solution'] ?? null,
                'implementation' => $validated['implementation'] ?? null,
                'outcome' => $validated['outcome'] ?? null,
            ]);

            // Skills
            if (! empty($validated['skills'])) {
                $project->skills()->sync($validated['skills']);
            }

            // Links
            if (! empty($validated['links'])) {
                foreach ($validated['links'] as $i => $link) {
                    if (! empty($link['url']) && ! empty($link['label'])) {
                        ProjectLink::create([
                            'project_id' => $project->id,
                            'link_type' => $link['link_type'] ?? 'live',
                            'label' => $link['label'],
                            'url' => $link['url'],
                            'sort_order' => $i,
                        ]);
                    }
                }
            }

            ActivityLog::log('project.create', ['title' => $project->title], $project);
        });

        CacheInvalidationService::invalidateProjects();

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project): View
    {
        $project->load(['detail', 'links', 'skills', 'coverImage']);
        $categories = ProjectCategory::orderBy('name')->get();
        $skills = Skill::with('category')->orderBy('sort_order')->get();
        $mediaImages = Media::where('mime_type', 'like', 'image/%')->latest()->get();

        return view('admin.projects.edit', compact('project', 'categories', 'skills', 'mediaImages'));
    }

    public function update(StoreProjectRequest $request, Project $project): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $project) {
            $isPublishing = ($project->status !== 'published' && $validated['status'] === 'published');

            $project->update([
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'category_id' => $validated['category_id'] ?? null,
                'summary' => $validated['summary'] ?? null,
                'description' => $validated['description'] ?? null,
                'cover_image_id' => $validated['cover_image_id'] ?? null,
                'status' => $validated['status'],
                'is_featured' => $validated['is_featured'] ?? false,
                'sort_order' => $validated['sort_order'] ?? 0,
                'published_at' => $isPublishing ? now() : $project->published_at,
            ]);

            ProjectDetail::updateOrCreate(
                ['project_id' => $project->id],
                [
                    'challenge' => $validated['challenge'] ?? null,
                    'solution' => $validated['solution'] ?? null,
                    'implementation' => $validated['implementation'] ?? null,
                    'outcome' => $validated['outcome'] ?? null,
                ]
            );

            $project->skills()->sync($validated['skills'] ?? []);

            $project->links()->delete();
            if (! empty($validated['links'])) {
                foreach ($validated['links'] as $i => $link) {
                    if (! empty($link['url']) && ! empty($link['label'])) {
                        ProjectLink::create([
                            'project_id' => $project->id,
                            'link_type' => $link['link_type'] ?? 'live',
                            'label' => $link['label'],
                            'url' => $link['url'],
                            'sort_order' => $i,
                        ]);
                    }
                }
            }

            ActivityLog::log('project.update', ['title' => $project->title], $project);
        });

        CacheInvalidationService::invalidateProjects($project->id);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $title = $project->title;
        $id = $project->id;
        $project->delete();

        ActivityLog::log('project.delete', ['title' => $title]);
        CacheInvalidationService::invalidateProjects($id);

        return redirect()->route('admin.projects.index')->with('success', "Project '{$title}' deleted successfully.");
    }

    public function toggleFeatured(Project $project): RedirectResponse
    {
        $project->update(['is_featured' => ! $project->is_featured]);
        CacheInvalidationService::invalidateProjects($project->id);

        return back()->with('success', 'Project featured status updated.');
    }
}
