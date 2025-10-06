<?php

namespace App\Http\Controllers\Admin\System;


use App\Http\Controllers\Controller;
use App\Http\Requests\UserGroupStoreRequest;
use App\Http\Requests\UserGroupUpdateRequest;
use App\Models\UserGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserGroupController extends Controller
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
     * @param UserGroupStoreRequest $userGroupStoreRequest
     * @return RedirectResponse
     */
    public function store(UserGroupStoreRequest $userGroupStoreRequest): RedirectResponse
    {
        $userGroup = UserGroup::create($userGroupStoreRequest->validated());

        return redirect(referer('admin.system.user-group.index'))
            ->with('success', $userGroup->name . ' added successfully.');
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
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.system.user-group.edit', compact('userGroup'));
    }

    /**
     * Update the specified user group in storage.
     *
     * @param UserGroupUpdateRequest $userGroupUpdateRequest
     * @param UserGroup $userGroup
     * @return RedirectResponse
     */
    public function update(UserGroupUpdateRequest $userGroupUpdateRequest, UserGroup $userGroup): RedirectResponse
    {
        $userGroup->update($userGroupUpdateRequest->validated());

        return redirect(referer('admin.system.user-group.index'))
            ->with('success', $userGroup->name . ' updated successfully.');
    }

    /**
     * Remove the specified user group from storage.
     *
     * @param UserGroup $userGroup
     * @return RedirectResponse
     */
    public function destroy(UserGroup $userGroup): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        $userGroup->delete();

        return redirect(referer('admin.system.user-group.index'))
            ->with('success', $userGroup->name . ' deleted successfully.');
    }
}
