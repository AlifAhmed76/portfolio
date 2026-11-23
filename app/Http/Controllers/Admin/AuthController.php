<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\ActivityLog;
use App\Models\ContactDetail;
use App\Models\HomepageSection;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\Theme;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceTheme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.register');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if (! $user->isActive() || ! $user->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->withErrors([
                'email' => 'Access denied. Account is not permitted to access dashboard.',
            ]);
        }

        ActivityLog::log('auth.login', [
            'email' => $user->email,
            'role' => $user->role,
        ]);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'alpha_dash',
                'min:3',
                'max:50',
                'unique:workspaces,slug',
                Rule::notIn(['admin', 'dashboard', 'login', 'register', 'logout', 'api', 'blog', 'projects', 'u', 'assets', 'vendor', 'sitemap.xml', 'robots.txt']),
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = DB::transaction(function () use ($validated, $request) {
            $slug = Str::slug($validated['username']);

            // 1. Create Workspace
            $workspace = Workspace::create([
                'name' => $validated['name'] . "'s Portfolio",
                'slug' => $slug,
                'status' => 'active',
            ]);

            // 2. Create Owner User
            $user = User::create([
                'workspace_id' => $workspace->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'owner',
                'status' => 'active',
            ]);

            // 3. Create Default Profile with chosen Full Name / Public Display Name
            Profile::create([
                'workspace_id' => $workspace->id,
                'name' => $validated['name'],
                'designation' => 'Web Developer & Creative Engineer',
                'headline' => 'Crafting High-Impact Digital Experiences & Scalable Web Solutions',
                'bio' => 'Welcome to my official portfolio. I design, build, and deploy modern applications with clean architecture and delightful user experiences.',
            ]);

            // 4. Create Default Contact Details
            ContactDetail::create([
                'workspace_id' => $workspace->id,
                'email' => $validated['email'],
                'availability_status' => 'Available for Select Projects & Collaborations',
                'location' => 'Worldwide Remote',
            ]);

            // 5. Default Site Settings
            $defaultSettings = [
                'site_title' => [$validated['name'] . ' — Portfolio', 'string'],
                'tagline' => ['Modern Web Applications & Systems Engineering', 'string'],
                'active_theme' => ['crystal-3d', 'string'],
                'accent_color' => ['#10b981', 'string'],
            ];
            foreach ($defaultSettings as $key => [$value, $type]) {
                SiteSetting::create([
                    'workspace_id' => $workspace->id,
                    'setting_key' => $key,
                    'setting_value' => $value,
                    'value_type' => $type,
                ]);
            }

            // 6. Default Homepage Sections
            $sections = [
                ['section_key' => 'hero', 'title' => 'Hero Banner', 'sort_order' => 1],
                ['section_key' => 'about', 'title' => 'About Me', 'sort_order' => 2],
                ['section_key' => 'projects', 'title' => 'Featured Projects', 'sort_order' => 3],
                ['section_key' => 'services', 'title' => 'Services & Offerings', 'sort_order' => 4],
                ['section_key' => 'skills', 'title' => 'Technical Competencies', 'sort_order' => 5],
                ['section_key' => 'experience', 'title' => 'Experience & Timeline', 'sort_order' => 6],
                ['section_key' => 'education', 'title' => 'Education & Qualifications', 'sort_order' => 7],
                ['section_key' => 'contact', 'title' => 'Get in Touch', 'sort_order' => 8],
            ];
            foreach ($sections as $sec) {
                HomepageSection::create([
                    'workspace_id' => $workspace->id,
                    'section_key' => $sec['section_key'],
                    'title' => $sec['title'],
                    'is_enabled' => true,
                    'sort_order' => $sec['sort_order'],
                ]);
            }

            // 7. Associate Default Active Theme
            $theme = Theme::where('slug', 'crystal-3d')->first();
            if ($theme) {
                WorkspaceTheme::create([
                    'workspace_id' => $workspace->id,
                    'theme_id' => $theme->id,
                    'is_active' => true,
                ]);
            }

            // 8. Starter Content
            $category = ProjectCategory::create([
                'workspace_id' => $workspace->id,
                'name' => 'Web Applications',
                'slug' => 'web-applications',
            ]);

            Project::create([
                'workspace_id' => $workspace->id,
                'category_id' => $category->id,
                'title' => 'Flagship Web Application',
                'slug' => 'flagship-web-application',
                'summary' => 'High-performance interactive web application built with modern architecture and responsive design.',
                'description' => 'A showcase project illustrating full-stack development, seamless UI components, and resilient cloud integration.',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 1,
                'published_at' => now(),
            ]);

            $skillCat = SkillCategory::create([
                'workspace_id' => $workspace->id,
                'name' => 'Core Technologies',
                'slug' => 'core-technologies',
                'sort_order' => 1,
            ]);

            $skills = [
                ['name' => 'PHP / Laravel', 'proficiency' => 95],
                ['name' => 'JavaScript / Modern Frontends', 'proficiency' => 90],
                ['name' => 'Database & REST APIs', 'proficiency' => 88],
                ['name' => 'UI / Responsive CSS', 'proficiency' => 92],
            ];
            foreach ($skills as $index => $sk) {
                Skill::create([
                    'workspace_id' => $workspace->id,
                    'category_id' => $skillCat->id,
                    'name' => $sk['name'],
                    'proficiency' => $sk['proficiency'],
                    'sort_order' => $index + 1,
                ]);
            }

            Service::create([
                'workspace_id' => $workspace->id,
                'title' => 'Custom Web Application Engineering',
                'description' => 'Architecting and deploying reliable, secure, and performant web systems tailored to your goals.',
                'icon' => 'code-2',
                'is_enabled' => true,
                'sort_order' => 1,
            ]);

            ActivityLog::create([
                'workspace_id' => $workspace->id,
                'user_id' => $user->id,
                'action' => 'auth.register',
                'metadata' => [
                    'email' => $user->email,
                    'workspace_slug' => $slug,
                    'name' => $user->name,
                ],
                'ip_hash' => hash('sha256', $request->ip() ?? 'unknown'),
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        $portfolioUrl = url('/u/' . $user->workspace->slug);

        return redirect()->route('admin.dashboard')->with('success', "Welcome to Portfolio Builder, {$user->name}! Your portfolio is live at: {$portfolioUrl}");
    }

    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            ActivityLog::log('auth.logout', [
                'email' => Auth::user()->email,
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been successfully logged out.');
    }
}
