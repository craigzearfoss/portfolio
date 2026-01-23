<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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

        if (!isAdmin() && !in_array($currentRouteName, ['admin.login', 'admin.login-submit'])) {
            return redirect()->route('admin.login');
        }

        if (!isRootAdmin()) {

            // only root admins can view and manipulate other users
            if (array_key_exists('owner_id', $request->all())) {
                $request->query->remove('owner_id');
            }
        }

        return $next($request);
    }
}
