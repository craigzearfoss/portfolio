<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreUserGroupsRequest;
use App\Http\Requests\System\UpdateUserGroupsRequest;
use App\Models\System\UserGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class UserGroupController extends BaseAdminController
{
    /**
     * Display a listing of user groups.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $userGroups = UserGroup::orderBy('name','asc')->paginate($perPage);

        return view('admin.system.user-group.index', compact('userGroups'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user group.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.system.user-group.create');
    }

    /**
     * Store a newly created user group in storage.
     *
     * @param StoreUserGroupsRequest $storeUserGroupRequest
     * @return RedirectResponse
     */
    public function store(StoreUserGroupsRequest $storeUserGroupRequest): RedirectResponse
    {
        $userGroup = UserGroup::create($storeUserGroupRequest->validated());

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
        return view('admin.system.user-group.show', compact('userGroup'));
    }

    /**
     * Show the form for editing the specified user group.
     *
     * @param UserGroup $userGroup
     * @return View
     */
    public function edit(UserGroup $userGroup): View
    {
        Gate::authorize('update-resource', $userGroup);

        return view('admin.system.user-group.edit', compact('userGroup'));
    }

    /**
     * Update the specified user group in storage.
     *
     * @param UpdateUserGroupsRequest $updateUserGroupRequest
     * @param UserGroup $userGroup
     * @return RedirectResponse
     */
    public function update(UpdateUserGroupsRequest $updateUserGroupRequest, UserGroup $userGroup): RedirectResponse
    {
        Gate::authorize('update-resource', $userGroup);

        $userGroup->update($updateUserGroupRequest->validated());

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
        Gate::authorize('delete-resource', $userGroup);

        $userGroup->delete();

        return redirect(referer('admin.system.user-group.index'))
            ->with('success', $userGroup->name . ' deleted successfully.');
    }
}
