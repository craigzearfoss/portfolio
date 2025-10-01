<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 *
 */
class AdminController extends BaseController
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

        return view('admin.admin.index', compact('admins'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.admin.create');
    }

    /**
     * Store a newly created admin in storage.
     *
     * @param AdminStoreRequest $adminStoreRequest
     * @return RedirectResponse
     */
    public function store(AdminStoreRequest $adminStoreRequest): RedirectResponse
    {
        $adminStoreRequest->validate($adminStoreRequest->rules());

        $admin = new Admin();
        $admin->admin_id = Auth::guard('admin')->user()->id;
        $admin->username = $adminStoreRequest->username;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->disabled = $request->disabled;

        $admin->save();

        return redirect(referer('admin.admin.index'))
            ->with('success', 'Admin ' . $admin->username . ' added successfully.');
    }

    /**
     * Display the specified admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function show(Admin $admin): View
    {
        return view('admin.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function edit(Admin $admin): View
    {
        // Note that any admin can edit themselves but only root admins can edit other admins.
        if (!Auth::guard('admin')->user()->root && ($admin->id !== Auth::guard('admin')->user()->id)) {
            abort(403);
        }

        return view('admin.admin.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     *
     * @param AdminUpdateRequest $adminUpdateRequest
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function update(AdminUpdateRequest $adminUpdateRequest, Admin $admin): RedirectResponse
    {
        $admin->update($adminUpdateRequest->validated());

        return redirect(referer('admin.admin.index'))
            ->with('success', $admin->username . ' updated successfully.');
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        // Note that only root admins can delete other admins, but they cannot delete themselves.
        if (Auth::guard('admin')->user()->root && ($admin->id !== Auth::guard('admin')->user()->id)) {
            $admin->delete();
        } else {
            abort(403);
        }

        return redirect(referer('admin.admin.index'))
            ->with('success', $admin->username . ' deleted successfully.');
    }
}
