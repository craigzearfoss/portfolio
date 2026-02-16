<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\System\UpdateAdminsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        return view(themedTemplate('admin.profile.show'));
    }

    /**
     * Show the form for editing the current admin.
     *
     * @return View
     */
    public function edit(): View
    {
        return view(themedTemplate('admin.profile.edit'));
    }

    /**
     * Update the current admin in storage.
     *
     * @param UpdateAdminsRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateAdminsRequest $request): RedirectResponse
    {
        die ('@TODO: ???? Controllers\ProfileController->update()');
        $admin = $this->admin;
        $admin->update($request->validated());

        return redirect()->route('admin.profile.show', 'admin')
            ->with('success', 'Profile successfully updated.');
    }

    /**
     * Display the change password page.
     *
     * @return View
     */
    public function change_password(): View
    {
        return view(themedTemplate('admin.profile.change-password'));
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

        if (Hash::check($request->password, $this->admin->password)) {
            return redirect()->back()->with('error', ' You cannot use your old password again.');
        }

        $this->admin->password = Hash::make($request->password);
        $this->admin->token = null;
        $this->admin->update();

        return redirect(referer('admin.portfolio.show'))
            ->with('success', 'User password successfully updated.');
    }
}
