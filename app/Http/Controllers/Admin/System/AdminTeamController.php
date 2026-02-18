<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminTeamsRequest;
use App\Http\Requests\System\UpdateAdminTeamsRequest;
use App\Models\System\AdminTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class AdminTeamController extends BaseAdminController
{
    /**
     * Display a listing of admin teams.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'admin-team', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $adminTeams = new AdminTeam()->searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootAdmin() && !empty($owner_id)) ? $this->owner->name . ' Teams' : 'Teams';

        return view('admin.system.admin-team.index', compact('adminTeams', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin team.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'admin-team', $this->admin);

        return view('admin.system.admin-team.create');
    }

    /**
     * Store a newly created admin team in storage.
     *
     * @param StoreAdminTeamsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminTeamsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'admin-team', $this->admin);

        $adminTeam = new AdminTeam()->create($request->validated());

        return redirect()->route('admin.system.admin-team.show', $adminTeam)
            ->with('success', $adminTeam->name . ' successfully added.');
    }

    /**
     * Display the specified admin team.
     *
     * @param AdminTeam $adminTeam
     * @return View
     */
    public function show(AdminTeam $adminTeam): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $adminTeam, $this->admin);

        list($prev, $next) = $adminTeam->prevAndNextPages(
            $adminTeam['id'],
            'admin.system.admin-team.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.admin-team.show', compact('adminTeam', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified admin team.
     *
     * @param AdminTeam $adminTeam
     * @return View
     */
    public function edit(AdminTeam $adminTeam): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $adminTeam, $this->admin);

        return view('admin.system.admin-team.edit', compact('adminTeam'));
    }

    /**
     * Update the specified admin team in storage.
     *
     * @param UpdateAdminTeamsRequest $request
     * @param AdminTeam $adminTeam
     * @return RedirectResponse
     */
    public function update(UpdateAdminTeamsRequest $request, AdminTeam $adminTeam): RedirectResponse
    {
        $adminTeam->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $adminTeam, $this->admin);

        return redirect()->route('admin.system.admin-team.show', $adminTeam)
            ->with('success', $adminTeam->name . ' successfully updated.');
    }

    /**
     * Remove the specified admin team from storage.
     *
     * @param AdminTeam $adminTeam
     * @return RedirectResponse
     */
    public function destroy(AdminTeam $adminTeam): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $adminTeam, $this->admin);

        $adminTeam->delete();

        return redirect(referer('admin.system.admin-team.index'))
            ->with('success', $adminTeam->name . ' deleted successfully.');
    }
}
