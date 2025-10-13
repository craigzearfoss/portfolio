<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/system.php',
            __DIR__.'/../routes/dictionary.php',
            __DIR__.'/../routes/portfolio.php',
            __DIR__.'/../routes/career.php',
            __DIR__.'/../routes/personal.php',
//            __DIR__.'/../routes/front.php',
//            __DIR__.'/../routes/user.php',
//            __DIR__.'/../routes/admin.php',
        ],
        api: [
            __DIR__.'/../routes/api.php',
            __DIR__.'/../routes/v1/api.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => App\Http\Middleware\Admin::class,
            'auth' => App\Http\Middleware\User::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
