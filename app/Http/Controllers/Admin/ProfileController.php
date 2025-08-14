<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the current admin.
     */
    public function show(): View
    {
        $admin = Auth::guard('admin')->user();

        $title = $admin->name;
        return view('admin.profile.show', compact('admin', 'title'));
    }

    /**
     * Show the form for editing the current admin.
     */
    public function edit(): View
    {
        $admin = Auth::guard('admin')->user();

        $title = 'Edit My Profile';
        return view('admin.profile.edit', compact('admin', 'title'));
    }

    /**
     * Update the current admin in storage.
     */
    public function update(AdminUpdateRequest $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $admin->update($request->validated());

        return redirect()->route('admin.show')
            ->with('success', 'Profile updated successfully');
    }

    /**
     * Display the change password page.
     */
    public function change_password(Admin $admin): View
    {
        return view('admin.profile.change_password', compact('admin'));
    }

    /**
     * Update the new password.
     */
    public function change_password_submit(AdminUpdateRequest $request, Admin $admin): RedirectResponse|View
    {
        $admin = Auth::guard('admin')->user();

        $admin->update($request->validated());

        return redirect()->route('admin.show', $admin)
            ->with('success', 'User password updated successfully');
    }
}
