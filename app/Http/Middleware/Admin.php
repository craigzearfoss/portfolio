<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin && !in_array(Route::currentRouteName(), ['admin.login', 'admin.login-submit'])) {
            return redirect()->route('admin.login');
        }

        // non-root users cannot make changes to the resources of other admins
        if (empty($admin->is_root)) {

            $method = $request->method();
            $owner_id = $request->get('owner_id');
/*
            if (!empty($owner_id)
                && in_array($method, [/*'POST',* / 'PUT', 'PATCH', 'DELETE'])
                && ($admin['id'] != $owner_id)
            ) {
                abort(403, 'You are not authorized to make changes to the resources of ' . $admin['username'] . '.');
            }
*/
            // in the admin area for non-root admins remove the owner_id url parameter
            // because non-root admins can only view themselves
            if (request()->exists('owner_id') && !isRootAdmin()) {
                $request->query->remove('owner_id');
            }
        }

        return $next($request);
    }
}
