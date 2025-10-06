<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\AdminTeamStoreRequest;
use App\Http\Requests\System\AdminTeamUpdateRequest;
use App\Models\AdminTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminTeamController extends Controller
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
     * @param AdminTeamStoreRequest $adminTeamStoreRequest
     * @return RedirectResponse
     */
    public function store(AdminTeamStoreRequest $adminTeamStoreRequest): RedirectResponse
    {
        $adminTeam = AdminTeam::create($adminTeamStoreRequest->validated());

        return redirect(referer('admin.system.admin-team.index'))
            ->with('success', $adminTeam->name . ' added successfully.');
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
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.system.admin-team.edit', compact('adminTeam'));
    }

    /**
     * Update the specified admin team in storage.
     *
     * @param AdminTeamUpdateRequest $adminTeamUpdateRequest
     * @param AdminTeam $adminTeam
     * @return RedirectResponse
     */
    public function update(AdminTeamUpdateRequest $adminTeamUpdateRequest, AdminTeam $adminTeam): RedirectResponse
    {
        $adminTeam->update($adminTeamUpdateRequest->validated());

        return redirect(referer('admin.system.admin-team.index'))
            ->with('success', $adminTeam->name . ' updated successfully.');
    }

    /**
     * Remove the specified admin team from storage.
     *
     * @param AdminTeam $adminTeam
     * @return RedirectResponse
     */
    public function destroy(AdminTeam $adminTeam): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        $adminTeam->delete();

        return redirect(referer('admin.system.admin-team.index'))
            ->with('success', $adminTeam->name . ' deleted successfully.');
    }
}
