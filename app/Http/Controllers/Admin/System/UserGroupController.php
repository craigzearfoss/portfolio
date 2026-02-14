<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\User\BaseUserController;
use App\Http\Requests\System\StoreUserGroupsRequest;
use App\Http\Requests\System\UpdateUserGroupsRequest;
use App\Models\System\UserGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class UserGroupController extends BaseUserController
{
    /**
     * Display a listing of user groups.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'user-group', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $userGroups = UserGroup::searchQuery($request->all())
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'User Groups';

        return view('admin.system.user-group.index', compact('userGroups', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user group.
     *
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'user-group', $this->admin);

        return view('admin.system.user-group.create');
    }

    /**
     * Store a newly created user group in storage.
     *
     * @param StoreUserGroupsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserGroupsRequest $request): RedirectResponse
    {
        $userGroup = UserGroup::create($request->validated());

        return redirect()->route('admin.system.user-group.show', $userGroup)
            ->with('success', $userGroup->name . ' successfully added.');
    }

    /**
     * Display the specified user group.
     *
     * @param UserGroup $userGroup
     * @return View
     */
    public function show(UserGroup $userGroup): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $userGroup, $this->admin);

        list($prev, $next) = UserGroup::prevAndNextPages($userGroup->id,
            'admin.system.user-group.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.system.user-group.show', compact('userGroup', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified user group.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $userGroup = UserGroup::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $userGroup, $this->admin);

        return view('admin.system.user-group.edit', compact('userGroup'));
    }

    /**
     * Update the specified user group in storage.
     *
     * @param UpdateUserGroupsRequest $request
     * @param UserGroup $userGroup
     * @return RedirectResponse
     */
    public function update(UpdateUserGroupsRequest $request, UserGroup $userGroup): RedirectResponse
    {
        $userGroup->update($request->validated());

        return redirect()->route('admin.system.user-group.show', $userGroup)
            ->with('success', $userGroup->name . ' successfully updated.');
    }

    /**
     * Remove the specified user group from storage.
     *
     * @param UserGroup $userGroup
     * @return RedirectResponse
     */
    public function destroy(UserGroup $userGroup): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $userGroup, $this->admin);

        $userGroup->delete();

        return redirect(referer('admin.system.user-group.index'))
            ->with('success', $userGroup->name . ' deleted successfully.');
    }
}
