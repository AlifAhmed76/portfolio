<?php

namespace App\Providers;

use App\Models\Profile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production') || request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }

        // Globally share active profile and current workspace with all views (memoized per-request)
        static $cachedProfile = null;
        static $cachedWorkspace = null;
        static $hasProfilesTable = null;

        View::composer('*', function ($view) use (&$cachedProfile, &$cachedWorkspace, &$hasProfilesTable) {
            if (! $view->offsetExists('profile')) {
                if ($hasProfilesTable === null) {
                    $hasProfilesTable = Schema::hasTable('profiles');
                }
                if ($hasProfilesTable) {
                    if ($cachedProfile === null) {
                        $cachedProfile = Profile::first();
                    }
                    $view->with('profile', $cachedProfile);
                }
            }
            if (! $view->offsetExists('currentWorkspace')) {
                if ($cachedWorkspace === null) {
                    $cachedWorkspace = \App\Services\WorkspaceResolver::current();
                }
                $view->with('currentWorkspace', $cachedWorkspace);
            }
        });
    }
}
