<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminGroupsRequest;
use App\Http\Requests\System\UpdateAdminGroupsRequest;
use App\Models\System\AdminGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
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
        readGate(AdminGroup::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $adminGroups = new AdminGroup()->searchQuery($request->all(), !empty($this->owner->is_root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' groups';

        return view('admin.system.admin-group.index', compact('adminGroups', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin group.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(AdminGroup::class, $this->admin);

        return view('admin.system.admin-group.create');
    }

    /**
     * Store a newly created admin group in storage.
     *
     * @param StoreAdminGroupsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminGroupsRequest $request): RedirectResponse
    {
        createGate(AdminGroup::class, $this->admin);

        $adminGroup = new AdminGroup()->create($request->validated());

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
        readGate($adminGroup, $this->admin);

        list($prev, $next) = $adminGroup->prevAndNextPages(
            $adminGroup['id'],
            'admin.system.admin-group.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

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
        updateGate(PermissionEntityTypes::RESOURCE, $adminGroup, $this->admin);

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
        $adminGroup->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $adminGroup, $this->admin);

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
        updateGate(PermissionEntityTypes::RESOURCE, $adminGroup, $this->admin);

        $adminGroup->delete();

        return redirect(referer('admin.system.admin-group.index'))
            ->with('success', $adminGroup->name . ' deleted successfully.');
    }
}
