<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminGroupsRequest;
use App\Http\Requests\System\UpdateAdminGroupsRequest;
use App\Models\System\AdminGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdminGroupController extends BaseAdminController
{
    /**
     * Display a listing of admin groups.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $adminGroups = AdminGroup::orderBy('name','asc')->paginate($perPage);

        return view('admin.system.admin-group.index', compact('adminGroups'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin group.
     *
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function create(): View
    {
        $owner_id = request()->get('owner_id');

        return view('admin.system.admin-group.create', compact('owner_id'));
    }

    /**
     * Store a newly created admin group in storage.
     *
     * @param StoreAdminGroupsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminGroupsRequest $request): RedirectResponse
    {
        $adminGroup = AdminGroup::create($request->validated());

        return redirect()->route('admin.system.admin-group.show', $adminGroup)
            ->with('success', $adminGroup->name . ' successfully added.');
    }

    /**
     * Display the specified admin group.
     *
     * @param AdminGroup $adminGroup
     * @return View
     */
    public function show(AdminGroup $adminGroup): View
    {
        list($prev, $next) = AdminGroup::prevAndNextPages($adminGroup->id,
            'admin.system.admin-group.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.system.admin-group.show', compact('adminGroup', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified admin group.
     *
     * @param AdminGroup $adminGroup
     * @return View
     */
    public function edit(AdminGroup $adminGroup): View
    {
        if (!canUpdate($adminGroup, $this->admin)) {
            abort(403, 'You are not allowed to edit this admin group.');
        }

        return view('admin.system.admin-group.edit', compact('adminGroup'));
    }

    /**
     * Update the specified admin group in storage.
     *
     * @param UpdateAdminGroupsRequest $request
     * @param AdminGroup $adminGroup
     * @return RedirectResponse
     */
    public function update(UpdateAdminGroupsRequest $request, AdminGroup $adminGroup): RedirectResponse
    {
        Gate::authorize('update-resource', $adminGroup);

        $adminGroup->update($request->validated());

        return redirect()->route('admin.system.admin-group.show', $adminGroup)
            ->with('success', $adminGroup->name . ' successfully updated.');
    }

    /**
     * Remove the specified admin group from storage.
     *
     * @param AdminGroup $adminGroup
     * @return RedirectResponse
     */
    public function destroy(AdminGroup $adminGroup): RedirectResponse
    {
        if (!canDelete($adminGroup, $this->admin)) {
            abort(403, 'You are not allowed to delete this admin group.');
        }

        $adminGroup->delete();

        return redirect(referer('admin.system.admin-group.index'))
            ->with('success', $adminGroup->name . ' deleted successfully.');
    }
}
