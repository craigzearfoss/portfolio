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
     * @param Request $request
     * @return View
     */
    public function show(Request $request): View
    {
        $admin = Auth::guard('admin')->user();
        $title = $admin->name;
        $referer = $request->headers->get('referer');

        return view('admin.profile.show', compact('admin', 'title', 'referer'));
    }

    /**
     * Show the form for editing the current admin.
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        $admin = Auth::guard('admin')->user();

        $title = 'Edit My Profile';
        $referer = $request->headers->get('referer');

        return view('admin.profile.edit', compact('admin', 'title', 'referer'));
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

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.link.index')
                ->with('success', 'Profile updated successfully.');
        }
    }

    /**
     * Display the change password page.
     *
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function change_password(Admin $admin, Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.profile.change-password', compact('admin', 'referer'));
    }

    /**
     * Update the new password.
     *
     * @param AdminUpdateRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function change_password_submit(AdminUpdateRequest $request, Admin $admin): RedirectResponse|View
    {
        $admin = Auth::guard('admin')->user();

        $admin->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'User password updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.link.index')
                ->with('success', 'User password updated successfully.');
        }
    }
}
