<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminResourcesRequest;
use App\Http\Requests\System\UpdateAdminResourcesRequest;
use App\Models\Portfolio\Video;
use App\Models\System\AdminResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class AdminResourceController extends BaseAdminController
{
    /**
     * Display a listing of admin resources.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'admin-resource', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $adminResources = AdminResource::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Resources' : 'Resources';

        return view('admin.system.admin-resource.index', compact('adminResources', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin resource.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'admin-resource', $this->admin);

        abort(403, 'Resources must be added by site developers.');
    }

    /**
     * Store a newly created admin resource in storage.
     *
     * @param StoreAdminResourcesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminResourcesRequest $request): RedirectResponse
    {
        abort(403, 'Resources must be added by site developers.');
    }

    /**
     * Display the specified admin resource.
     *
     * @param AdminResource $adminResource
     * @return View
     */
    public function show(AdminResource $adminResource): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $adminResource, $this->admin);

        list($prev, $next) = AdminResource::prevAndNextPages($adminResource->id,
            'admin.system.admin-resource.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.system.admin-resource.show', compact('adminResource', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified admin resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $adminResource = AdminResource::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $adminResource, $this->admin);

        return view('admin.system.admin-resource.edit', compact('adminResource'));
    }

    /**
     * Update the specified admin resource in storage.
     *
     * @param UpdateAdminResourcesRequest $request
     * @param AdminResource $adminResource
     * @return RedirectResponse
     */
    public function update(UpdateAdminResourcesRequest $request, AdminResource $adminResource): RedirectResponse
    {
        die('@TODO: ???? AdminResourceController->update()');
        $adminResource->update($request->validated());

        return redirect()->route('admin.system.admin-resource.show', $adminResource)
            ->with('success', $adminResource->name . ' successfully updated.');
    }

    /**
     * Remove the specified admin resource from storage.
     *
     * @param AdminResource $adminResource
     * @return RedirectResponse
     */
    public function destroy(AdminResource $adminResource): RedirectResponse
    {
        abort(403, 'Resources cannot be deleted.');
    }
}
