<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
        if ($admin = $request->route('admin')) {
            if (empty($admin->is_public)) {
                abort(404);
            }
        }
        */

        return $next($request);
    }
}
