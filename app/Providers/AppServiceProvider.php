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

        // Globally share active profile and current workspace with all views
        View::composer('*', function ($view) {
            if (! $view->offsetExists('profile')) {
                if (Schema::hasTable('profiles')) {
                    $view->with('profile', Profile::first());
                }
            }
            if (! $view->offsetExists('currentWorkspace')) {
                $view->with('currentWorkspace', \App\Services\WorkspaceResolver::current());
            }
        });
    }
}
