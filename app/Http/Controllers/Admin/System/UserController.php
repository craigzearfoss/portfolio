<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\BaseController;
use App\Http\Requests\System\UserStoreRequest;
use App\Http\Requests\System\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends BaseController
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

        $users = User::orderBy('username','asc')->paginate($perPage);

        return view('admin.system.user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.system.user.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserStoreRequest $userStoreRequest
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $userStoreRequest): RedirectResponse
    {
        $user = User::create($userStoreRequest->validated());

        return redirect(referer('admin.system.user.index'))
            ->with('success', $user->username . ' added successfully. User will need to verify email.');
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('admin.system.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.system.user.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect(referer('admin.system.user.index'))
            ->with('success', $user->username . ' updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect(referer('admin.system.user.index'))
            ->with('success', $user->name . ' deleted successfully.');
    }

    /**
     * Display the change password page.
     *
     * @param User $user
     * @return View
     */
    public function change_password(User $user): View
    {
        return view('admin.system.user.change-password', compact('user'));
    }

    /**
     * Update the new password.
     *
     * @param UserUpdateRequest $userUpdateRequest
     * @param User $user
     * @return RedirectResponse
     */
    public function change_password_submit(UserUpdateRequest $userUpdateRequest, User $user): RedirectResponse
    {
        $user->update($userUpdateRequest->validated());

        return redirect(referer('admin.system.user.show', $user))
            ->with('success', 'Password for ' . $user->username . ' updated successfully.');
    }
}
