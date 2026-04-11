<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/system.php',
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/dictionary.php',
            __DIR__.'/../routes/portfolio.php',
            __DIR__.'/../routes/career.php',
            __DIR__.'/../routes/personal.php',
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
            'user'  => App\Http\Middleware\User::class,
            'guest' => App\Http\Middleware\Guest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        if (App::environment('production')) {
            // don't show detailed model not found message in production
            $exceptions->map(
                ModelNotFoundException::class,
                function (ModelNotFoundException $exception): NotFoundHttpException {
                    return new NotFoundHttpException("Not found.", $exception);
                }
            );
        }
    })->create();
