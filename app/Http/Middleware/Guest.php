<?php

namespace App\Http\Middleware;

use App\Models\System\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentRouteName = Route::currentRouteName();

        if ($admin = $request->route('admin')) {
            if (empty($admin->public)) {
                abort(404);
            }
        }

        // inject the logged in $admin and $user variables into templates
        view()->share('loggedInAdmin', loggedInAdmin());
        view()->share('loggedInUser', loggedInUser());

        view()->share('currentRouteName', $currentRouteName);
        view()->share('admin', loggedInAdmin());
        view()->share('user', loggedInUser());

        return $next($request);
    }
}
