<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\UserStoreRequest;
use App\Mail\ResetPassword;
use App\Mail\VerifyEmail;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class IndexController extends BaseController
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
