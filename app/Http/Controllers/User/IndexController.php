<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IndexController extends BaseUserController
{
    public function index(): View
    {
        if (Auth::guard('web')->check()) {
            return view('user.dashboard');
        } else {
            return view('guest.index');
        }
    }

    public function dashboard()
    {
        return view('user.dashboard');
    }
}
