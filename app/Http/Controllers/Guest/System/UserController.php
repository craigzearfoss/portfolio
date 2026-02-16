<?php

namespace App\Http\Controllers\Guest\System;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;

class UserController extends BaseGuestController
{
    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(Request $request): Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $users = new User()->orderBy('username')
            ->paginate($perPage)->appends(request()->except('page'));

        return view('guest.system.user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * @param User $user
     * @return Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function show(User $user): Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        if (!$user->public || $user->disabled) {
            abort(404);
        }
        return view(themedTemplate('guest.system.user.show'), compact('user'));
    }
}
