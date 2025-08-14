<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the current user.
     */
    public function show(): View
    {
        $user = Auth::user();

        $title = $user->name;
        return view('user.profile.show', compact('user', 'title'));
    }

    /**
     * Show the form for editing the current user.
     */
    public function edit(): View
    {
        $user = Auth::user();

        $title = 'Edit My Profile';
        return view('user.profile.edit', compact('user', 'title'));
    }

    /**
     * Update the current user in storage.
     */
    public function update(UserUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $user->update($request->validated());

        return redirect()->route('user.show')
            ->with('success', 'Profile updated successfully');
    }

    /**
     * Display the change password page.
     */
    public function change_password(User $user): View
    {
        return view('user.profile.change_password', compact('user'));
    }

    /**
     * Update the new password.
     */
    public function change_password_submit(UserUpdateRequest $request, User $user): RedirectResponse|View
    {
        $user = Auth::user();

        $user->update($request->validated());

        return redirect()->route('user.show', $user)
            ->with('success', 'User password updated successfully');
    }
}
