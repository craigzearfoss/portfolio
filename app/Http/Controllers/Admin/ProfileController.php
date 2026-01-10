<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\System\UpdateAdminsRequest;
use App\Models\System\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        return view(themedTemplate('admin.profile.show'), compact('admin'));
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
     * @param UpdateAdminsRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateAdminsRequest $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $admin->update($request->validated());

        return redirect()->route('admin.profile.show', $admin)
            ->with('success', 'Profile successfully updated.');
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
     * @return RedirectResponse|View
     */
    public function change_password_submit(Request $request): RedirectResponse|View
    {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password']
        ]);

        $admin = Auth::guard('admin')->user();

        if (Hash::check($request->password, $admin->password)) {
            return redirect()->back()->with('error', ' You cannot use your old password again.');
        }

        $admin->password = Hash::make($request->password);
        $admin->token = null;
        $admin->update();

        return redirect(referer('admin.portfolio.show'))
            ->with('success', 'User password successfully updated.');
    }
}
