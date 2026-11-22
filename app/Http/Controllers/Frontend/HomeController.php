<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactDetail;
use App\Models\Education;
use App\Models\Experience;
use App\Models\HomepageSection;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Project;
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

        $profile = Profile::with(['avatar', 'profileImage', 'resume'])->first();
        $contact = ContactDetail::first();
        $socialLinks = SocialLink::where('is_enabled', true)->orderBy('sort_order')->get();
        $sections = HomepageSection::where('is_enabled', true)->orderBy('sort_order')->get();

        $featuredProjects = Project::with(['category', 'coverImage', 'skills'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->get();

        $skillCategories = SkillCategory::with('skills')->orderBy('sort_order')->get();
        $services = Service::where('is_enabled', true)->orderBy('sort_order')->get();
        $experiences = Experience::orderBy('sort_order')->orderByDesc('start_date')->get();
        $educations = Education::orderBy('sort_order')->get();
        $recentPosts = Post::published()->with(['category', 'tags'])->latest('published_at')->take(3)->get();

        $stats = [
            ['value' => '5+', 'label' => 'Years Engineering Experience', 'icon' => 'calendar'],
            ['value' => '30+', 'label' => 'Enterprise Solutions Delivered', 'icon' => 'check-circle'],
            ['value' => '99.8%', 'label' => 'Tracking Attribution Accuracy', 'icon' => 'activity'],
            ['value' => '$2M+', 'label' => 'E-Commerce GMV Orchestrated', 'icon' => 'trending-up'],
        ];

        return view(ThemeResolver::getView('pages.home'), compact(
            'theme',
            'tokens',
            'profile',
            'contact',
            'socialLinks',
            'sections',
            'featuredProjects',
            'skillCategories',
            'services',
            'experiences',
            'educations',
            'recentPosts',
            'stats'
        ));
    }
}
