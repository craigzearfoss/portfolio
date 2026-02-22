<?php

namespace App\Http\Controllers\Guest;

use App\Http\Requests\MessageStoreRequest;
use App\Models\System\Admin;
use App\Models\System\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    /**
     * Guest index (home) page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $adminModel = new Admin();

        $admin = null;
        $admins = $adminModel->where('public', 1)
            ->where('disabled', false)
            ->orderBy('name')->paginate($perPage)->appends(request()->except('page'));

        if ($featuredUsername = config('app.featured_admin')) {
            $featuredAdmin = $adminModel->where('username', $featuredUsername)->first();
        } else {
            $featuredAdmin = null;
        }

        return view(themedTemplate('guest.index'), compact('admin', 'admins', 'featuredAdmin'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the guest about page.
     *
     * @return View
     */
    public function about(): View
    {
        return view(themedTemplate('guest.about'));
    }

    /**
     * Display the guest contact and conditions page.
     *
     * @return View
     */
    public function contact(): View
    {
        return view(themedTemplate('guest.contact'));
    }


    /**
     * Store a submitted guest contact message in storage.
     *
     * @param MessageStoreRequest $messageStoreRequest
     * @return RedirectResponse
     */
    public function storeContactMessage(MessageStoreRequest $messageStoreRequest): RedirectResponse
    {
        $message = new Message()->create($messageStoreRequest->validated());

        return redirect(route('guest.index'))
            ->with('success', 'Your message has been sent. Thank you!.');
    }

    /**
     * Display the guest privacy policy page.
     *
     * @return View
     */
    public function privacy_policy(): View
    {
        return view(themedTemplate('guest.privacy-policy'));
    }

    /**
     * Display the guest terms and conditions page.
     *
     * @return View
     */
    public function terms_and_conditions(): View
    {
        return view(themedTemplate('guest.terms-and-conditions'));
    }
}
