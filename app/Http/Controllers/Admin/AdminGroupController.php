<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminGroupStoreRequest;
use App\Http\Requests\AdminGroupUpdateRequest;
use App\Models\AdminGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminGroupController extends Controller
{
    /**
     * Display a listing of admin groups.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $adminGroups = AdminGroup::orderBy('name','asc')->paginate($perPage);

        return view('admin.admin-group.index', compact('adminGroups'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin group.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.admin-group.create');
    }

    /**
     * Store a newly created admin group in storage.
     *
     * @param AdminGroupStoreRequest $adminGroupStoreRequest
     * @return RedirectResponse
     */
    public function store(AdminGroupStoreRequest $adminGroupStoreRequest): RedirectResponse
    {
        $adminGroup = AdminGroup::create($adminGroupStoreRequest->validated());

        return redirect(referer('admin.admin-group.index'))
            ->with('success', $adminGroup->name . ' added successfully.');
    }

    /**
     * Display the specified admin group.
     *
     * @param AdminGroup $adminGroup
     * @return View
     */
    public function show(AdminGroup $adminGroup): View
    {
        return view('admin.admin-group.show', compact('adminGroup'));
    }

    /**
     * Show the form for editing the specified admin group.
     *
     * @param AdminGroup $adminGroup
     * @return View
     */
    public function edit(AdminGroup $adminGroup): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.admin-group.edit', compact('adminGroup'));
    }

    /**
     * Update the specified admin group in storage.
     *
     * @param AdminGroupUpdateRequest $request
     * @param AdminGroup $adminGroup
     * @return RedirectResponse
     */
    public function update(AdminGroupUpdateRequest $request, AdminGroup $adminGroup): RedirectResponse
    {
        $adminGroup->update($request->validated());

        return redirect(referer('admin.admin-group.index'))
            ->with('success', $adminGroup->name . ' updated successfully.');
    }

    /**
     * Remove the specified admin group from storage.
     *
     * @param AdminGroup $adminGroup
     * @return RedirectResponse
     */
    public function destroy(AdminGroup $adminGroup): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        $adminGroup->delete();

        return redirect(referer('admin.admin-group.index'))
            ->with('success', $adminGroup->name . ' deleted successfully.');
    }
}
