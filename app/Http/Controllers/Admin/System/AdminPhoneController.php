<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminPhonesRequest;
use App\Http\Requests\System\UpdateAdminPhonesRequest;
use App\Models\System\AdminPhone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPhoneController extends BaseAdminController
{
    /**
     * Display a listing of admin phones.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'admin-phone', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $adminPhones = new AdminPhone()->searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootAdmin() && !empty($owner_id)) ? $this['owner']->name . ' Phones' : 'Phones';

        return view('admin.system.admin-phone.index', compact('adminPhones', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin phone.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'admin-phone', $this->admin);

        return view('admin.system.admin-phone.create');
    }

    /**
     * Store a newly created admin phone in storage.
     *
     * @param StoreAdminPhonesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminPhonesRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'admin-phone', $this->admin);

        $adminPhone = new AdminPhone()->create($request->validated());

        return redirect()->route('admin.system.admin-phone.show', $adminPhone)
            ->with('success', $adminPhone->name . ' successfully added.');
    }

    /**
     * Display the specified admin phone.
     *
     * @param AdminPhone $adminPhone
     * @return View
     */
    public function show(AdminPhone $adminPhone): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $adminPhone, $this->admin);

        list($prev, $next) = $adminPhone->prevAndNextPages(
            $adminPhone['id'],
            'admin.system.admin-phone.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.admin-phone.show', compact('adminPhone', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified admin phone.
     *
     * @param AdminPhone $adminPhone
     * @return View
     */
    public function edit(AdminPhone $adminPhone): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $adminPhone, $this->admin);

        return view('admin.system.admin-phone.edit', compact('adminPhone'));
    }

    /**
     * Update the specified admin phone in storage.
     *
     * @param UpdateAdminPhonesRequest $request
     * @param AdminPhone $adminPhone
     * @return RedirectResponse
     */
    public function update(UpdateAdminPhonesRequest $request, AdminPhone $adminPhone): RedirectResponse
    {
        $adminPhone->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $adminPhone, $this->admin);

        return redirect()->route('admin.system.admin-phone.show', $adminPhone)
            ->with('success', $adminPhone['name'] . ' successfully updated.');
    }

    /**
     * Remove the specified admin phone from storage.
     *
     * @param AdminPhone $adminPhone
     * @return RedirectResponse
     */
    public function destroy(AdminPhone $adminPhone): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $adminPhone, $this->admin);

        $adminPhone->delete();

        return redirect(referer('admin.system.admin-phone.index'))
            ->with('success', $adminPhone['name'] . ' deleted successfully.');
    }
}
