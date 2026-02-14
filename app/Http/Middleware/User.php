<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        die('@TODO ???? User->handle()');
        $currentRouteName = Route::currentRouteName();

        if (!isUser() && !in_array(Route::currentRouteName(), ['user.login', 'user.login-submit'])) {
            return redirect()->route('user.login');
        }

        return $next($request);
    }
}
