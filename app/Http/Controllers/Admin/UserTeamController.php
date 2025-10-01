<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserTeamStoreRequest;
use App\Http\Requests\UserTeamUpdateRequest;
use App\Models\UserTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserTeamController extends Controller
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

        return view('admin.user-team.index', compact('userTeams'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user team.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.user-team.create');
    }

    /**
     * Store a newly created user team in storage.
     *
     * @param UserTeamStoreRequest $userTeamStoreRequest
     * @return RedirectResponse
     */
    public function store(UserTeamStoreRequest $userTeamStoreRequest): RedirectResponse
    {
        $userTeam = UserTeam::create($userTeamStoreRequest->validated());

        return redirect(referer('admin.user-team.index'))
            ->with('success', $userTeam->name . ' added successfully.');
    }

    /**
     * Display the specified user team.
     *
     * @param UserTeam $userTeam
     * @return View
     */
    public function show(UserTeam $userTeam): View
    {
        return view('admin.user-team.show', compact('userTeam'));
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

        return view('admin.user-team.edit', compact('userTeam'));
    }

    /**
     * Update the specified user team in storage.
     *
     * @param UserTeamUpdateRequest $userTeamUpdateRequest
     * @param UserTeam $userTeam
     * @return RedirectResponse
     */
    public function update(UserTeamUpdateRequest $userTeamUpdateRequest, UserTeam $userTeam): RedirectResponse
    {
        $userTeam->update($userTeamUpdateRequest->validated());

        return redirect(referer('admin.user-team.index'))
            ->with('success', $userTeam->name . ' updated successfully.');
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

        return redirect(referer('admin.user-team.index'))
            ->with('success', $userTeam->name . ' deleted successfully.');
    }
}
