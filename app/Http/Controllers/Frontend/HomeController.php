<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactDetail;
use App\Models\Education;
use App\Models\Experience;
use App\Models\HomepageSection;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\SkillCategory;
use App\Models\SocialLink;
use App\Services\ThemeResolver;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $theme = ThemeResolver::resolve();
        $tokens = ThemeResolver::getTokens();

        $profile = Profile::first();
        $contact = ContactDetail::first();
        $socialLinks = SocialLink::where('is_enabled', true)->orderBy('sort_order')->get();
        $sections = HomepageSection::where('is_enabled', true)->orderBy('sort_order')->get();

        $featuredProjects = Project::with(['category', 'coverImage', 'skills', 'detail', 'links'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->get();

        $allProjects = Project::with(['category', 'coverImage', 'skills', 'detail', 'links'])
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->get();

        $projectCategories = ProjectCategory::withCount(['projects' => fn($q) => $q->where('status', 'published')])
            ->orderBy('name')
            ->get();

        $skillCategories = SkillCategory::with(['skills' => fn($q) => $q->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        $services = Service::where('is_enabled', true)->orderBy('sort_order')->get();
        $experiences = Experience::orderByDesc('start_date')->get();
        $educations = Education::orderByDesc('start_date')->get();

        return view(ThemeResolver::getView('pages.home'), compact(
            'theme',
            'tokens',
            'profile',
            'contact',
            'socialLinks',
            'sections',
            'featuredProjects',
            'allProjects',
            'projectCategories',
            'skillCategories',
            'services',
            'experiences',
            'educations'
        ));
    }
}
