<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\MessageStoreRequest;
use App\Models\System\Admin;
use App\Models\System\Message;
use App\Services\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends BaseController
{
    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $this->setCurrentAdminAndUser();
    }

    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $admin = null;
        $admins = \App\Models\System\Admin::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('name', 'asc')->paginate($perPage);

        if ($featuredUsername = config('app.featured_admin')) {
            $featuredAdmin = Admin::where('username', $featuredUsername)->first();
        } else {
            $featuredAdmin = null;
        }

        return view(themedTemplate('system.index'), compact('admin', 'admins', 'featuredAdmin'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
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

        return redirect(route('home'))
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
