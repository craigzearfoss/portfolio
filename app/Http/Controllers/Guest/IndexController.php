<?php

namespace App\Http\Controllers\Guest;

use App\Http\Middleware\Admin;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\System\StoreUsersRequest;
use App\Mail\ForgotUsername;
use App\Mail\ResetPassword;
use App\Mail\VerifyEmail;
use App\Models\System\Message;
use App\Models\System\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

        $admin = null;
        $admins = \App\Models\System\Admin::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('name', 'asc')->paginate($perPage);

        if ($featuredUsername = config('app.featured_admin')) {
            $featuredAdmin = \App\Models\System\Admin::where('username', $featuredUsername)->first();
        } else {
            $featuredAdmin = null;
        }

        return view(themedTemplate('system.index'), compact('admin', 'admins', 'featuredAdmin'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Guest candidates home page.
     *
     * @param Request $request
     * @return View
     */
    public function candidates(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $admin = null;
        $candidates = \App\Models\System\Admin::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('name', 'asc')->paginate($perPage);

        return view(themedTemplate('guest.system.admin.index'), compact('admin', 'candidates'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }
}
