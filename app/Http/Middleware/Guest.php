<?php

namespace App\Http\Middleware;

use App\Models\System\Admin;
use Closure;
use Illuminate\Http\Request;
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
        if ($admin = $request->route('admin')) {
            if (empty($admin->public)) {
                abort(404);
            }
        }

        // inject the current admin into blade templates
        if ($adminId = $request->cookie('guest_admin_id')) {
            View::share('admin', Admin::find(intval($adminId)));
        } else {
            View::share('admin', null);
        }

        return $next($request);
    }
}
