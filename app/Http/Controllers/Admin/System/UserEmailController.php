<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\User\BaseUserController;
use App\Http\Requests\System\StoreUserEmailsRequest;
use App\Http\Requests\System\UpdateUserEmailsRequest;
use App\Models\System\UserEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserEmailController extends BaseUserController
{
    /**
     * Display a listing of user emails.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'user-email', $this->user);

        $perPage = $request->query('per_page', $this->perPage());

        $userEmails = new UserEmail()->searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootUser() && !empty($owner_id)) ? $this['owner']->name . ' Emails' : 'Emails';

        return view('admin.system.user-email.index', compact('userEmails', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user email.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'user-email', $this->user);

        return view('admin.system.user-email.create');
    }

    /**
     * Store a newly created user email in storage.
     *
     * @param StoreUserEmailsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserEmailsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'user-email', $this->user);

        $userEmail = new UserEmail()->create($request->validated());

        return redirect()->route('admin.system.user-email.show', $userEmail)
            ->with('success', $userEmail->name . ' successfully added.');
    }

    /**
     * Display the specified user email.
     *
     * @param UserEmail $userEmail
     * @return View
     */
    public function show(UserEmail $userEmail): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $userEmail, $this->user);

        list($prev, $next) = $userEmail->prevAndNextPages(
            $userEmail['id'],
            'admin.system.user-email.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.user-email.show', compact('userEmail', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified user email.
     *
     * @param UserEmail $userEmail
     * @return View
     */
    public function edit(UserEmail $userEmail): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $userEmail, $this->user);

        return view('admin.system.user-email.edit', compact('userEmail'));
    }

    /**
     * Update the specified user email in storage.
     *
     * @param UpdateUserEmailsRequest $request
     * @param UserEmail $userEmail
     * @return RedirectResponse
     */
    public function update(UpdateUserEmailsRequest $request, UserEmail $userEmail): RedirectResponse
    {
        $userEmail->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $userEmail, $this->user);

        return redirect()->route('admin.system.user-email.show', $userEmail)
            ->with('success', $userEmail['name'] . ' successfully updated.');
    }

    /**
     * Remove the specified user email from storage.
     *
     * @param UserEmail $userEmail
     * @return RedirectResponse
     */
    public function destroy(UserEmail $userEmail): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $userEmail, $this->user);

        $userEmail->delete();

        return redirect(referer('admin.system.user-email.index'))
            ->with('success', $userEmail['name'] . ' deleted successfully.');
    }
}
