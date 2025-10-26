<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseSystemController;
use App\Http\Requests\MessageStoreRequest;
use App\Models\System\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends BaseSystemController
{
    public function index(): View
    {
        $admin = null;
        return view(themedTemplate('system.index'), compact('admin'));
    }

    public function about(): View
    {
        return view(themedTemplate('system.about'));
    }

    public function contact(): View
    {
        return view(themedTemplate('system.contact'));
    }

    /**
     * Store a submitted contact message in storage.
     *
     * @param MessageStoreRequest $messageStoreRequest
     * @return RedirectResponse
     */
    public function storeMessage(MessageStoreRequest $messageStoreRequest): RedirectResponse
    {
        $message = Message::create($messageStoreRequest->validated());

        return redirect(route('system.index'))
            ->with('success', 'Your message has been sent. Thank you!.');
    }

    public function privacy_policy(): View
    {
        return view(themedTemplate('system.privacy-policy'));
    }

    public function terms_and_conditions(): View
    {
        return view(themedTemplate('system.terms-and-conditions'));
    }
    //
}
