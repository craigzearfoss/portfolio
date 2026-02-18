<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminDatabasesRequest;
use App\Http\Requests\System\UpdateAdminDatabasesRequest;
use App\Models\System\AdminDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class AdminDatabaseController extends BaseAdminController
{
    /**
     * Display a listing of admin databases.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'admin-database', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $adminDatabases = new AdminDatabase()->searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootAdmin() && !empty($owner_id)) ? $this->owner->name . ' Databases' : 'Databases';

        return view('admin.system.admin-database.index', compact('adminDatabases', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin databases.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'admin-database', $this->admin);

        abort(403, 'Admin databases must be added by site developers.');
    }

    /**
     * Store a newly created admin databases in storage.
     *
     * @param StoreAdminDatabasesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminDatabasesRequest $request): RedirectResponse
    {
        abort(403, 'Admin databases must be added by site developers.');
    }

    /**
     * Display the specified admin databases.
     *
     * @param AdminDatabase $adminDatabase
     * @return View
     */
    public function show(AdminDatabase $adminDatabase): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $adminDatabase, $this->admin);

        list($prev, $next) = $adminDatabase->prevAndNextPages(
            $adminDatabase['id'],
            'admin.system.admin-database.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.admin-database.show', compact('adminDatabase', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified admin databases.
     *
     * @param AdminDatabase $adminDatabase
     * @return View
     */
    public function edit(AdminDatabase $adminDatabase): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $adminDatabase, $this->admin);

        return view('admin.system.admin-database.edit', compact('adminDatabase'));
    }

    /**
     * Update the specified admin databases in storage.
     *
     * @param UpdateAdminDatabasesRequest $request
     * @param AdminDatabase $adminDatabase
     * @return RedirectResponse
     */
    public function update(UpdateAdminDatabasesRequest $request, AdminDatabase $adminDatabase): RedirectResponse
    {
        $adminDatabase->update($request->validated());
        updateGate(PermissionEntityTypes::RESOURCE, $adminDatabase, $this->admin);

        return redirect()->route('admin.system.admin-database.show', $adminDatabase)
            ->with('success', $adminDatabase->name . ' successfully updated.');
    }

    /**
     * Remove the specified admin databases from storage.
     *
     * @param AdminDatabase $adminDatabase
     * @return RedirectResponse
     */
    public function destroy(AdminDatabase $adminDatabase): RedirectResponse
    {
        abort(403, 'Admin databases cannot be deleted.');
    }
}
