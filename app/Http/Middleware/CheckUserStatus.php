<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->requires_relogin) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            // Optionally, update the flag back to false after logout
            Auth::user()->update(['requires_relogin' => false]);
            return redirect('/login')->with('status', 'Your account requires re-authentication.');
        }
        return $next($request);
    }
}
