<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\System\UpdateUsersRequest;
use App\Models\System\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class ProfileController extends BaseUserController
{
    /**
     * Display the current user.
     *
     * @return View
     */
    public function show(): View
    {
        $user = Auth::user();
        $title = $user->name;

        return view('user.profile.show', compact('user', 'title'));
    }

    /**
     * Show the form for editing the current user.
     *
     * @return View
     */
    public function edit(): View
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update the current user in storage.
     *
     * @param UpdateUsersRequest $updateUsersRequest
     * @return RedirectResponse
     */
    public function update(UpdateUsersRequest $updateUsersRequest): RedirectResponse
    {
        $user = Auth::guard('web')->user();

        $user->update($updateUsersRequest->validated());

        return redirect()->route('user.show')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Display the change password page.
     *
     * @param User $user
     * @return View
     */
    public function change_password(User $user): View
    {
        return view('user.profile.change-password', compact('user'));
    }

    /**
     * Update the new password.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|View
     */
    public function change_password_submit(Request $request, User $user): RedirectResponse|View
    {
        $user = Auth::guard('web')->user();

        $user->update($request->validated());

        return redirect()->route('user.show', $user)
            ->with('success', 'User password updated successfully.');
    }
}
