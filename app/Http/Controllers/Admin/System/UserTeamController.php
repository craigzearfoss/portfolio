<?php

namespace App\Http\Controllers\Admin\System;

use App\Exports\System\UserTeamsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreUserTeamsRequest;
use App\Http\Requests\System\UpdateUserTeamsRequest;
use App\Models\System\UserTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
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
        if (!$this->isRootAdmin) {
            readGate(UserTeam::class, $this->user);
        }

        $perPage = $request->query('per_page', $this->perPage());

        // note that any user can see all user teams
        $userTeams = new UserTeam()->searchQuery(
            $request->all(),
            request()->input('sort') ?? implode('|', UserTeam::SEARCH_ORDER_BY),
        )
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
        createGate(UserTeam::class, $this->admin);

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
        $userTeam = UserTeam::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $userTeam['name'] . ' successfully added.');
        } else {
            return redirect()->route('user.system.user-team.show', $userTeam)
                ->with('success', $userTeam['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified user team.
     *
     * @param UserTeam $userTeam
     * @return View
     */
    public function show(UserTeam $userTeam): View
    {
        readGate($userTeam, $this->admin);

        list($prev, $next) = $userTeam->prevAndNextPages(
            $userTeam['id'],
            'admin.system.user-team.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.user-team.show', compact('userTeam', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified user team.
     *
     * @param UserTeam $userTeam
     * @return View
     */
    public function edit(UserTeam $userTeam): View
    {
        updateGate($userTeam, $this->admin);

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

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $userTeam['name'] . ' successfully updated.');
        } else {
            return redirect()->route('user.system.user-team.show', $userTeam)
                ->with('success', $userTeam['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified user team from storage.
     *
     * @param UserTeam $userTeam
     * @return RedirectResponse
     */
    public function destroy(UserTeam $userTeam): RedirectResponse
    {
        deleteGate($userTeam, $this->admin);

        $userTeam->delete();

        return redirect(referer('user.system.user-team.index'))
            ->with('success', $userTeam['name'] . ' deleted successfully.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(UserTeam::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'user_teams_' . date("Y-m-d-His") . '.xlsx'
            : 'user_teams.xlsx';

        return Excel::download(new UserTeamsExport(), $filename);
    }
}
