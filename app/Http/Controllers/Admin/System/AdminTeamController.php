<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminTeamsRequest;
use App\Http\Requests\System\UpdateAdminTeamsRequest;
use App\Models\System\AdminTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

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
        $perPage = $request->query('per_page', $this->perPage);

        $adminTeams = AdminTeam::orderBy('name','asc')->paginate($perPage);

        return view('admin.system.admin-team.index', compact('adminTeams'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin team.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

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
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can add new admin teams.');
        }

        $adminTeam = AdminTeam::create($request->validated());

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
        return view('admin.system.admin-team.show', compact('adminTeam'));
    }

    /**
     * Show the form for editing the specified admin team.
     *
     * @param AdminTeam $adminTeam
     * @return View
     */
    public function edit(AdminTeam $adminTeam): View
    {
        Gate::authorize('update-resource', $adminTeam);

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
        Gate::authorize('update-resource', $adminTeam);

        $adminTeam->update($request->validated());

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
        Gate::authorize('delete-resource', $adminTeam);

        $adminTeam->delete();

        return redirect(referer('admin.system.admin-team.index'))
            ->with('success', $adminTeam->name . ' deleted successfully.');
    }
}
