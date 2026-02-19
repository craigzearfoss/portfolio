<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminEmailsRequest;
use App\Http\Requests\System\UpdateAdminEmailsRequest;
use App\Models\System\AdminEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class AdminEmailController extends BaseAdminController
{
    /**
     * Display a listing of admin emails.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'admin-email', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $adminEmails = new AdminEmail()->searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootAdmin() && !empty($owner_id)) ? $this['owner']->name . ' Emails' : 'Emails';

        return view('admin.system.admin-email.index', compact('adminEmails', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin email.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'admin-email', $this->admin);

        return view('admin.system.admin-email.create');
    }

    /**
     * Store a newly created admin email in storage.
     *
     * @param StoreAdminEmailsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminEmailsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'admin-email', $this->admin);

        $adminEmail = new AdminEmail()->create($request->validated());

        return redirect()->route('admin.system.admin-email.show', $adminEmail)
            ->with('success', $adminEmail->name . ' successfully added.');
    }

    /**
     * Display the specified admin email.
     *
     * @param AdminEmail $adminEmail
     * @return View
     */
    public function show(AdminEmail $adminEmail): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $adminEmail, $this->admin);

        list($prev, $next) = $adminEmail->prevAndNextPages(
            $adminEmail['id'],
            'admin.system.admin-email.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.admin-email.show', compact('adminEmail', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified admin email.
     *
     * @param AdminEmail $adminEmail
     * @return View
     */
    public function edit(AdminEmail $adminEmail): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $adminEmail, $this->admin);

        return view('admin.system.admin-email.edit', compact('adminEmail'));
    }

    /**
     * Update the specified admin email in storage.
     *
     * @param UpdateAdminEmailsRequest $request
     * @param AdminEmail $adminEmail
     * @return RedirectResponse
     */
    public function update(UpdateAdminEmailsRequest $request, AdminEmail $adminEmail): RedirectResponse
    {
        $adminEmail->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $adminEmail, $this->admin);

        return redirect()->route('admin.system.admin-email.show', $adminEmail)
            ->with('success', $adminEmail['name'] . ' successfully updated.');
    }

    /**
     * Remove the specified admin email from storage.
     *
     * @param AdminEmail $adminEmail
     * @return RedirectResponse
     */
    public function destroy(AdminEmail $adminEmail): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $adminEmail, $this->admin);

        $adminEmail->delete();

        return redirect(referer('admin.system.admin-email.index'))
            ->with('success', $adminEmail['name'] . ' deleted successfully.');
    }
}
