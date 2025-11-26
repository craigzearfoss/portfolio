<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreUserTeamsRequest;
use App\Http\Requests\System\UpdateUserTeamsRequest;
use App\Models\System\UserTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserTeamController extends BaseAdminController
{
    /**
     * Display a listing of user teams.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $userTeams = UserTeam::orderBy('name','asc')->paginate($perPage);

        return view('admin.system.user-team.index', compact('userTeams'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user team.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.system.user-team.create');
    }

    /**
     * Store a newly created user team in storage.
     *
     * @param StoreUserTeamsRequest $storeUserTeamsRequest
     * @return RedirectResponse
     */
    public function store(StoreUserTeamsRequest $storeUserTeamsRequest): RedirectResponse
    {
        $userTeam = UserTeam::create($storeUserTeamsRequest->validated());

        return redirect()->route('admin.system.user-team.show', $userTeam)
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
        return view('admin.system.user-team.show', compact('userTeam'));
    }

    /**
     * Show the form for editing the specified user team.
     *
     * @param UserTeam $userTeam
     * @return View
     */
    public function edit(UserTeam $userTeam): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.system.user-team.edit', compact('userTeam'));
    }

    /**
     * Update the specified user team in storage.
     *
     * @param UpdateUserTeamsRequest $updateUserTeamsRequest
     * @param UserTeam $userTeam
     * @return RedirectResponse
     */
    public function update(UpdateUserTeamsRequest $updateUserTeamsRequest, UserTeam $userTeam): RedirectResponse
    {
        $userTeam->update($updateUserTeamsRequest->validated());

        return redirect()->route('admin.system.user-team.show', $userTeam)
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
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        $userTeam->delete();

        return redirect(referer('admin.system.user-team.index'))
            ->with('success', $userTeam->name . ' deleted successfully.');
    }
}
