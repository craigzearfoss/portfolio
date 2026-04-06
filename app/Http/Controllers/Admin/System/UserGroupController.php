<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreUserGroupsRequest;
use App\Http\Requests\System\UpdateUserGroupsRequest;
use App\Models\System\UserGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
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
        if (!$this->isRootAdmin) {
            readGate(UserGroup::class, $this->user);
        }

        $perPage = $request->query('per_page', $this->perPage());

        // note that any user can see all user teams
        $userGroups = new UserGroup()->searchQuery(
            $request->all(),
            request()->input('sort') ?? implode('|', UserGroup::SEARCH_ORDER_BY),
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'User Groups';

        return view('admin.system.user-group.index', compact('userGroups', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user group.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(UserGroup::class, $this->admin);

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
        $userGroup = UserGroup::query()->create($request->validated());

        return redirect()->route('admin.system.user-group.show', $userGroup)
            ->with('success', $userGroup['name'] . ' successfully added.');
    }

    /**
     * Display the specified user group.
     *
     * @param UserGroup $userGroup
     * @return View
     */
    public function show(UserGroup $userGroup): View
    {
        readGate($userGroup, $this->admin);

        list($prev, $next) = $userGroup->prevAndNextPages(
            $userGroup['id'],
            'admin.system.user-group.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.user-group.show', compact('userGroup', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified user group.
     *
     * @param UserGroup $userGroup
     * @return View
     */
    public function edit(UserGroup $userGroup): View
    {
        updateGate($userGroup, $this->admin);

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
            ->with('success', $userGroup['name'] . ' successfully updated.');
    }

    /**
     * Remove the specified user group from storage.
     *
     * @param UserGroup $userGroup
     * @return RedirectResponse
     */
    public function destroy(UserGroup $userGroup): RedirectResponse
    {
        deleteGate($userGroup, $this->admin);

        $userGroup->delete();

        return redirect(referer('admin.system.user-group.index'))
            ->with('success', $userGroup['name'] . ' deleted successfully.');
    }
}
