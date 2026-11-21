<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ThemeResolver;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::with(['category', 'coverImage'])
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(12);

        return view(ThemeResolver::getView('pages.projects.index'), compact('projects'));
    }

    public function show(string $slug): View
    {
        $project = Project::with(['category', 'coverImage', 'detail', 'links', 'skills'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view(ThemeResolver::getView('pages.projects.show'), compact('project'));
    }
}
