<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the admin.
     */
    public function index(): View
    {
        $admins = Admin::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.admin.index', compact('admins'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create(): View
    {
        return view('admin.admin.create');
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(AdminStoreRequest $request): RedirectResponse
    {
        $request->validate($request->rules());

        $admin = new Admin();
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->disabled = $request->disabled;

        $admin->save();

        return redirect()->route('admin.admin.index')
            ->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified admin.
     */
    public function show(Admin $admin): View
    {
        return view('admin.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(Admin $admin)
    {
        return view('admin.admin.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(AdminUpdateRequest $request, Admin $admin): RedirectResponse
    {
        $admin->update($request->validated());

        return redirect()->route('admin.admin.index')
            ->with('success', 'Admin updated successfully');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        $admin->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Admin deleted successfully');
    }
}
