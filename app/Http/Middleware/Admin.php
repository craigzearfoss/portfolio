<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentRouteName = Route::currentRouteName();

        if (!isAdmin()) {
            return redirect()->route('admin.login');
        }

        if (!empty($adminId)) {
            View::share('currentAdmin', \App\Models\System\Admin::find(intval($adminId)));
        } else {
            View::share('currentAdmin', null);
        }

        // inject the logged in $admin and $user variables into templates
        view()->share('currentRouteName', $currentRouteName);
        view()->share('admin', getAdmin());
        view()->share('user', getUser());

        return $next($request);
    }
}
