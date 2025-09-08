<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\BaseController;
use Illuminate\View\View;

class IndexController extends BaseController
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
