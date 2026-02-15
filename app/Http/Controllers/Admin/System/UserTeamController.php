<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\User\BaseUserController;
use App\Http\Requests\System\StoreUserTeamsRequest;
use App\Http\Requests\System\UpdateUserTeamsRequest;
use App\Models\System\UserTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class UserTeamController extends BaseUserController
{
    /**
     * Display a listing of user teams.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'user-team', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $userTeams = UserTeam::searchQuery($request->all())
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'User Teams';

        return view('admin.system.user-team.index', compact('userTeams', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user team.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'user-team', $this->admin);

        return view('admin.system.user-team.create');
    }

    /**
     * Store a newly created user team in storage.
     *
     * @param StoreUserTeamsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserTeamsRequest $request): RedirectResponse
    {
        $userTeam = new UserTeam()->create($request->validated());

        return redirect()->route('user.system.user-team.show', $userTeam)
            ->with('success', $userTeam->name . ' successfully added.');
    }

    /**
     * Display the specified user team.
     *
     * @param UserTeam $userTeam
     * @return View
     */
    public function show(UserTeam $userTeam): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $userTeam, $this->admin);

        list($prev, $next) = UserTeam::prevAndNextPages($userTeam->id,
            'admin.system.user-team.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.system.user-team.show', compact('userTeam', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified user team.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $userTeam = new UserTeam()->findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $userTeam, $this->admin);

        return view('admin.system.user-team.edit', compact('userTeam'));
    }

    /**
     * Update the specified user team in storage.
     *
     * @param UpdateUserTeamsRequest $request
     * @param UserTeam $userTeam
     * @return RedirectResponse
     */
    public function update(UpdateUserTeamsRequest $request, UserTeam $userTeam): RedirectResponse
    {
        $userTeam->update($request->validated());

        return redirect()->route('user.system.user-team.show', $userTeam)
            ->with('success', $userTeam->name . ' successfully updated.');
    }

    /**
     * Remove the specified user team from storage.
     *
     * @param UserTeam $userTeam
     * @return RedirectResponse
     */
    public function destroy(UserTeam $userTeam): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $userTeam, $this->admin);

        $userTeam->delete();

        return redirect(referer('user.system.user-team.index'))
            ->with('success', $userTeam->name . ' deleted successfully.');
    }
}
