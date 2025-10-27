<?php

namespace App\Http\Controllers\Guest\System;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\System\StoreUsersRequest;
use App\Mail\ForgotUsername;
use App\Mail\ResetPassword;
use App\Mail\VerifyEmail;
use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\Message;
use App\Models\System\Resource;
use App\Models\System\User;
use App\Services\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminController extends BaseGuestController
{
    /**
     * Display a listing of admins.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $admins = \App\Models\System\Admin::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('username', 'asc')->paginate($perPage);

        return view('guest.system.admin.index', compact('admins'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    public function show(Admin $admin): View
    {
        if (!$admin->public || $admin->disabled) {
            abort(404);
        }

        $portfolioResources = Database::getResources('portfolio', [], ['name', 'asc']);
        $personalResources = Database::getResources('personal', [], ['name', 'asc']);

        return view(themedTemplate(
            'guest.system.admin.show'),
            compact('admin', 'portfolioResources', 'personalResources')
        );
    }
}
