<?php

namespace App\Http\Controllers\Admin\System;

use App\Exports\System\AdminGroupsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminGroupsRequest;
use App\Http\Requests\System\UpdateAdminGroupsRequest;
use App\Models\System\AdminGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class AdminGroupController extends BaseAdminController
{
    /**
     * Display a listing of admin groups.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(AdminGroup::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        // note that any admin can see all admin groups
        $adminGroups = new AdminGroup()->searchQuery(
            $request->all(),
            request()->input('sort') ?? implode('|', AdminGroup::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Groups';

        return view('admin.system.admin-group.index', compact('adminGroups', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin group.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(AdminGroup::class, $this->admin);

        return view('admin.system.admin-group.create');
    }

    /**
     * Store a newly created admin group in storage.
     *
     * @param StoreAdminGroupsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminGroupsRequest $request): RedirectResponse
    {
        createGate(AdminGroup::class, $this->admin);

        $adminGroup = AdminGroup::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $adminGroup['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.system.admin-group.show', $adminGroup)
                ->with('success', $adminGroup['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified admin group.
     *
     * @param AdminGroup $adminGroup
     * @return View
     */
    public function show(AdminGroup $adminGroup): View
    {
        readGate($adminGroup, $this->admin);

        list($prev, $next) = $adminGroup->prevAndNextPages(
            $adminGroup['id'],
            'admin.system.admin-group.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.admin-group.show', compact('adminGroup', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified admin group.
     *
     * @param AdminGroup $adminGroup
     * @return View
     */
    public function edit(AdminGroup $adminGroup): View
    {
        updateGate($adminGroup, $this->admin);

        return view('admin.system.admin-group.edit', compact('adminGroup'));
    }

    /**
     * Update the specified admin group in storage.
     *
     * @param UpdateAdminGroupsRequest $request
     * @param AdminGroup $adminGroup
     * @return RedirectResponse
     */
    public function update(UpdateAdminGroupsRequest $request, AdminGroup $adminGroup): RedirectResponse
    {
        $adminGroup->update($request->validated());

        updateGate($adminGroup, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $adminGroup['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.system.admin-group.show', $adminGroup)
                ->with('success', $adminGroup['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified admin group from storage.
     *
     * @param AdminGroup $adminGroup
     * @return RedirectResponse
     */
    public function destroy(AdminGroup $adminGroup): RedirectResponse
    {
        updateGate($adminGroup, $this->admin);

        $adminGroup->delete();

        return redirect(referer('admin.system.admin-group.index'))
            ->with('success', $adminGroup['name'] . ' deleted successfully.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(AdminGroup::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'admin_groups_' . date("Y-m-d-His") . '.xlsx'
            : 'admin_groups.xlsx';

        return Excel::download(new AdminGroupsExport(), $filename);
    }
}
