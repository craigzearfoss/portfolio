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
        return view(themedTemplate('guest.index'));
    }
}
