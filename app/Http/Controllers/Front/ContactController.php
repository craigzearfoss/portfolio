<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Http\Requests\MessageStoreRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        $title = 'Contact Us';
        return view('front.contact', compact('title'));
    }

    public function store(MessageStoreRequest $request): View
    {
        Message::create($request->validated());
        return view('front.contact-submitted');
    }
}
