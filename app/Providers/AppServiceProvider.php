<?php

namespace App\Providers;

use App\Services\MenuService;
use App\Services\PermissionService;
use Illuminate\Pagination\Paginator;
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
    public function boot(): void
    {
        Paginator::useBootstrap();

        view()->share('demo', boolval(config('app.demo')));
        view()->share('readonly', boolval(config('app.readonly')));
    }
}
