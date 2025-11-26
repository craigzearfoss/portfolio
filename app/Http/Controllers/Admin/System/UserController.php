<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreUsersRequest;
use App\Http\Requests\System\UpdateUsersRequest;
use App\Models\System\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends BaseAdminController
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
     * @param StoreUsersRequest $storeUsersRequest
     * @return RedirectResponse
     */
    public function store(StoreUsersRequest $storeUsersRequest): RedirectResponse
    {
        $user = User::create($storeUsersRequest->validated());

        return redirect()->route('admin.system.user.show', $user)
            ->with('success', $user->username . ' successfully added. User will need to verify email.');
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
     * @param UpdateUsersRequest $updateUsersRequest
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUsersRequest $updateUsersRequest, User $user): RedirectResponse
    {
        $user->update($updateUsersRequest->validated());

        return redirect()->route('admin.system.user.show', $user)
            ->with('success', $user->username . ' successfully updated.');
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
     * @param UpdateUsersRequest $userUpdateRequest
     * @param User $user
     * @return RedirectResponse
     */
    public function change_password_submit(UpdateUsersRequest $userUpdateRequest, User $user): RedirectResponse
    {
        $userUpdateRequest->validate([
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password']
        ]);

        if (Hash::check($userUpdateRequest->password, $user->password)) {
            return redirect()->back()->with('error', ' You cannot use your old password again.');
        }

        $user->password = Hash::make($userUpdateRequest->password);
        $user->update();

        return redirect(referer('admin.system.user.show', $user))
            ->with('success', 'Password for ' . $user->username . ' successfully updated.');
    }
}
