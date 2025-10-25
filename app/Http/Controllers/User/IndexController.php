<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IndexController extends BaseUserController
{
    public function index(): View
    {
        if (Auth::guard('user')->check()) {
            return view('user.dashboard');
        } else {
            return view(themedTemplate('guest.index'));
        }
    }

    public function dashboard()
    {
        return view(themedTemplate('user.dashboard'));
    }
}
