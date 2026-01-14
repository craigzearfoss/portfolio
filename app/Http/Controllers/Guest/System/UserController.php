<?php

namespace App\Http\Controllers\Guest\System;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends BaseGuestController
{
    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $users = User::orderBy('username', 'asc')->paginate($perPage);

        return view('guest.system.user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    public function show(User $user): View
    {
        if (!$user->public || $user->disabled) {
            abort(404);
        }
        return view(themedTemplate('guest.system.user.show'), compact('user'));
    }
}
