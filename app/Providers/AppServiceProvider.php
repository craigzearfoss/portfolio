<?php

namespace App\Providers;

use App\Models\System\Admin;
use App\Models\System\User;
use App\Observers\System\AdminObserver;
use App\Observers\System\UserObserver;
use App\Services\PermissionService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
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
     *
     * @return void
     */
    public function boot(): void
    {
        // register observers
        Admin::observe(AdminObserver::class);
        User::observe(UserObserver::class);

        // use the app.secure_urls setting instead of checking the production environment variable for greater flexibility
        //if (App::environment('production')) {
        if (config('app.secure_urls')) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();

        // @TODO: fix dated
        // define gate for admin editing a resource
        Gate::define('update-resource', function ($resourceObj, Admin $admin): bool
        {
            if (!empty($admin->is_root)) return true;

            if (property_exists($resourceObj, 'owner_id') && ($resourceObj->owner_id === $admin['id'])) {
                return true;
            } else {
                return false;
            }
        });

        // define gate for an admin deleting a resource
        Gate::define('delete-resource', function (Admin $admin, $resourceObj): bool
        {
            if (!empty($admin->is_root)) return true;

            if (property_exists($resourceObj, 'owner_id') && ($resourceObj->owner_id === $admin['id'])) {
                return true;
            } else {
                return false;
            }
        });

        view()->share('demo', config('app.demo_mode'));
        view()->share('readonly', config('app.readonly'));

        view()->share('adminTableClasses', implode(' ', []));
        view()->share('userTableClasses', implode(' ', []));
        view()->share('guestTableClasses', implode(' ', config('app.guest_table_classes')));
    }
}
