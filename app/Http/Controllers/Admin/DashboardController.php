<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Profile;
use App\Models\SiteSetting;
use App\Services\WorkspaceResolver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $workspace = WorkspaceResolver::resolve();
        $profile = Profile::first();

        $recentActivities = ActivityLog::with('user')
            ->latest('id')
            ->limit(10)
            ->get();

        $draftProjects = Schema::hasTable('projects')
            ? DB::table('projects')->where('status', 'draft')->count()
            : 0;

        $publishedProjects = Schema::hasTable('projects')
            ? DB::table('projects')->where('status', 'published')->count()
            : 0;

        $postsCount = Schema::hasTable('posts')
            ? DB::table('posts')->count()
            : 0;

        $unreadMessages = Schema::hasTable('contact_messages')
            ? DB::table('contact_messages')->where('status', 'unread')->count()
            : 0;

        $stats = [
            'workspace_name' => $workspace?->name ?? 'Default Workspace',
            'owner_name' => $profile?->name ?? 'Md. Alif Ahmed',
            'designation' => $profile?->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist',
            'active_theme' => SiteSetting::get('active_theme', 'crystal-3d'),
            'draft_projects_count' => $draftProjects,
            'published_projects_count' => $publishedProjects,
            'posts_count' => $postsCount,
            'unread_messages_count' => $unreadMessages,
        ];

        $systemHealth = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database' => config('database.default'),
            'storage_writable' => true,
            'cache_driver' => config('cache.default'),
        ];

        return view('admin.dashboard', compact('workspace', 'profile', 'recentActivities', 'stats', 'systemHealth'));
    }
}
