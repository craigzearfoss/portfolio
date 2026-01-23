<?php

namespace App\Providers;

use App\Http\Middleware\Admin;
use App\Services\PermissionService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PermissionService::class, function ($app) {
            return new PermissionService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(\Request $request): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();

        // define gate for admin editing a resource
        Gate::define('update-resource', function ($resourceObj, Admin $admin): bool
        {d($admin);
            if ($admin->root) return true;

            if (property_exists($resourceObj, 'owner_id') && ($resourceObj->owner_id === $admin->id)) {
                return true;
            } else {
                return false;
            }
        });

        // define gate for an admin deleting a resource
        Gate::define('delete-resource', function (Admin $admin, $resourceObj): bool
        {
            if ($admin->root) return true;

            if (property_exists($resourceObj, 'owner_id') && ($resourceObj->owner_id === $admin->id)) {
                return true;
            } else {
                return false;
            }
        });

        view()->share('demo', config('app.demo_mode'));
        view()->share('readonly', config('app.readonly'));
    }
}
