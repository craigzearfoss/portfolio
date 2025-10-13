<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\System\UpdateAdminsRequest;
use App\Models\System\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class ProfileController extends BaseAdminController
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

        return view(themedTemplate('admin.profile.show'), compact('admin', 'title'));
    }

    /**
     * Show the form for editing the current admin.
     *
     * @return View
     */
    public function edit(): View
    {
        $admin = Auth::guard('admin')->user();
        return view(themedTemplate('admin.profile.edit'), compact('admin'));
    }

    /**
     * Update the current admin in storage.
     *
     * @param UpdateAdminsRequest $updateAdminsRequest
     * @return RedirectResponse
     */
    public function update(UpdateAdminsRequest $updateAdminsRequest): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $admin->update($updateAdminsRequest->validated());

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
        return view(themedTemplate('admin.profile.change-password'), compact('admin'));
    }

    /**
     * Update the new password.
     *
     * @param Request $request
     * @param Admin $admin
     * @return RedirectResponse|View
     */
    public function change_password_submit(Request $request, Admin $admin): RedirectResponse|View
    {
        $admin = Auth::guard('admin')->user();

        $admin->update($request->validated());

        return redirect(referer('admin.portfolio.show'))
            ->with('success', 'User password updated successfully.');
    }
}
