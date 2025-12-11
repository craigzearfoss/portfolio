<?php

namespace App\Providers;

use App\Services\PermissionService;
use Illuminate\Pagination\Paginator;
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

        view()->share('demo', !empty(config('app.demo_url')));
        view()->share('readonly', boolval(config('app.readonly')));
    }
}
