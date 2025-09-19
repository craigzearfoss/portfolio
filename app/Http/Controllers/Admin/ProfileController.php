<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class ProfileController extends BaseController
{
    /**
     * Display the current admin.
     *
     * @return View
     */
    public function show(): View
    {
        $admin = Auth::guard('admin')->user();
        $title = $admin->name;

        return view('admin.profile.show', compact('admin', 'title'));
    }

    /**
     * Show the form for editing the current admin.
     *
     * @return View
     */
    public function edit(): View
    {
        $admin = Auth::guard('admin')->user();

        $title = 'Edit My Profile';

        return view('admin.profile.edit', compact('admin', 'title'));
    }

    /**
     * Update the current admin in storage.
     *
     * @param AdminUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(AdminUpdateRequest $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $admin->update($request->validated());

        return redirect(referer('admin.portfolio.show'))
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Display the change password page.
     *
     * @param Admin $admin
     * @return View
     */
    public function change_password(Admin $admin): View
    {
        return view('admin.profile.change-password', compact('admin'));
    }

    /**
     * Update the new password.
     *
     * @param AdminUpdateRequest $request
     * @param Admin $admin
     * @return RedirectResponse|View
     */
    public function change_password_submit(AdminUpdateRequest $request, Admin $admin): RedirectResponse|View
    {
        $admin = Auth::guard('admin')->user();

        $admin->update($request->validated());

        return redirect(referer('admin.portfolio.show'))
            ->with('success', 'User password updated successfully.');
    }
}
