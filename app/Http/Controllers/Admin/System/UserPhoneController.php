<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\User\BaseUserController;
use App\Http\Controllers\Controller;
use App\Http\Requests\System\StoreUserPhonesRequest;
use App\Http\Requests\System\UpdateUserPhonesRequest;
use App\Models\System\UserPhone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserPhoneController extends BaseUserController
{
    /**
     * Display a listing of user phones.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'user-phone', $this->user);

        $perPage = $request->query('per_page', $this->perPage());

        $userPhones = new UserPhone()->searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootUser() && !empty($owner_id)) ? $this['owner']->name . ' Phones' : 'Phones';

        return view('user.system.user-phone.index', compact('userPhones', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user phone.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'user-phone', $this->user);

        return view('user.system.user-phone.create');
    }

    /**
     * Store a newly created user phone in storage.
     *
     * @param StoreUserPhonesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserPhonesRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'user-phone', $this->user);

        $userPhone = new UserPhone()->create($request->validated());

        return redirect()->route('user.system.user-phone.show', $userPhone)
            ->with('success', $userPhone->name . ' successfully added.');
    }

    /**
     * Display the specified user phone.
     *
     * @param UserPhone $userPhone
     * @return View
     */
    public function show(UserPhone $userPhone): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $userPhone, $this->user);

        list($prev, $next) = $userPhone->prevAndNextPages(
            $userPhone['id'],
            'user.system.user-phone.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('user.system.user-phone.show', compact('userPhone', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified user phone.
     *
     * @param UserPhone $userPhone
     * @return View
     */
    public function edit(UserPhone $userPhone): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $userPhone, $this->user);

        return view('user.system.user-phone.edit', compact('userPhone'));
    }

    /**
     * Update the specified user phone in storage.
     *
     * @param UpdateUserPhonesRequest $request
     * @param UserPhone $userPhone
     * @return RedirectResponse
     */
    public function update(UpdateUserPhonesRequest $request, UserPhone $userPhone): RedirectResponse
    {
        $userPhone->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $userPhone, $this->user);

        return redirect()->route('user.system.user-phone.show', $userPhone)
            ->with('success', $userPhone['name'] . ' successfully updated.');
    }

    /**
     * Remove the specified user phone from storage.
     *
     * @param UserPhone $userPhone
     * @return RedirectResponse
     */
    public function destroy(UserPhone $userPhone): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $userPhone, $this->user);

        $userPhone->delete();

        return redirect(referer('user.system.user-phone.index'))
            ->with('success', $userPhone['name'] . ' deleted successfully.');
    }
}
