<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\UserStoreRequest;
use App\Mail\ResetPassword;
use App\Mail\VerifyEmail;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function about(): View
    {
        $title = 'About Us';
        return view('front.about', compact('title'));
    }

    public function contact(): View
    {
        $title = 'Contact Us';
        return view('front.contact', compact('title'));
    }

    public function privacy_policy(): View
    {
        $title = 'Privacy Policy';
        return view('front.privacy-policy', compact('title'));
    }

    public function terms_and_conditions(): View
    {
        $title = 'Terms & Conditions';
        return view('front.terms-and-conditions', compact('title'));
    }
}
