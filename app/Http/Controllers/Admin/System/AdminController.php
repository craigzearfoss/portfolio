<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminsRequest;
use App\Http\Requests\System\UpdateAdminsRequest;
use App\Models\System\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 *
 */
class AdminController extends BaseAdminController
{
    /**
     * Display a listing of admins.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $admins = Admin::orderBy('username', 'asc')->paginate($perPage);

        return view('admin.system.admin.index', compact('admins'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.system.admin.create');
    }

    /**
     * Store a newly created admin in storage.
     *
     * @param StoreAdminsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminsRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can create new admins.');
        }

        $request->validate($request->rules());

        $admin = new Admin();
        $admin->username = $request->username;
        $admin->email    = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->disabled = $request->disabled;

        $admin->save();

        return redirect()->route('admin.system.admin.show', $admin)
            ->with('success', 'Admin ' . $admin->username . ' successfully added.');
    }

    /**
     * Display the specified admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function show(Admin $admin): View
    {
        return view('admin.system.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function edit(Admin $admin): View
    {
        Gate::authorize('update-resource', $admin);

        return view('admin.system.admin.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     *
     * @param UpdateAdminsRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function update(UpdateAdminsRequest $request, Admin $admin): RedirectResponse
    {
        Gate::authorize('update-resource', $admin);

        $admin->update($request->validated());

        return redirect()->route('admin.system.admin.show', $admin)
            ->with('success', $admin->username . ' successfully updated.');
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        Gate::authorize('delete-resource', $admin);

        return redirect(referer('admin.system.admin.index'))
            ->with('success', $admin->username . ' deleted successfully.');
    }
}
