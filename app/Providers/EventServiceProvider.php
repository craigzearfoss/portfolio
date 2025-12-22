<?php

namespace App\Providers;

use App\Listeners\LogLogout;
use App\Listeners\LogLoginFail;
use App\Listeners\LogLoginSuccess;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Failed::class => [
            LogLoginFail::class,
        ],
        Login::class => [
            LogLoginSuccess::class,
        ],
        Logout::class => [
            LogLogout::class,
        ],
    ];

    /**
     * Register any events for you application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}
