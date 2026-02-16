<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Career\StoreJobSearchLogsRequest;
use App\Http\Requests\Career\UpdateJobSearchLogsRequest;
use App\Models\Career\JobSearchLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobSearchLogController extends BaseAdminController
{
    /**
     * Display a listing of job search log entries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'job-search-log', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $jobSearchLogs = JobSearchLogController::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Job Search Log' : 'Job Search Log';

        return view('admin.career.job-search-log.index', compact('jobSearchLogs', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job search log entry.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'job-search-log', $this->admin);

        return view('admin.career.job-search-log.create');
    }

    /**
     * Store a newly created job search log entry in storage.
     *
     * @param StoreJobSearchLogsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreJobSearchLogsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'job-search-log', $this->admin);

        $logEntry = new JobSearchLogController()->create($request->validated());

        return redirect()->route('admin.career.job-search-log.show', $logEntry)
            ->with('success', 'Log entry successfully added.');
    }

    /**
     * Display the specified job search log entry.
     *
     * @param JobSearchLogController $jobSearchLog
     * @return View
     */
    public function show(JobSearchLogController $jobSearchLog): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $jobSearchLog, $this->admin);

        list($prev, $next) = JobSearchLogController::prevAndNextPages($jobSearchLog->id,
            'admin.career.job-search-log.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.career.job-search-log.show', compact('jobSearchLog', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified job search log entry.
     *
     * @param JobSearchLogController $jobSearchLog
     * @return View
     */
    public function edit(JobSearchLogController $jobSearchLog): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $jobSearchLog, $this->admin);

        return view('admin.career.job-search-log.edit', compact('jobSearchLog'));
    }

    /**
     * Update the specified job search log entry in storage.
     *
     * @param UpdateJobSearchLogsRequest $request
     * @param JobSearchLogController $jobSearchLog
     * @return RedirectResponse
     */
    public function update(UpdateJobSearchLogsRequest $request, JobSearchLogController $jobSearchLog): RedirectResponse
    {
        $jobSearchLog->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $jobSearchLog, $this->admin);

        return redirect()->route('admin.career.job-search-log.show', $jobSearchLog)
            ->with('success', 'Log entry successfully updated.');
    }

    /**
     * Remove the specified job search log entry from storage.
     *
     * @param JobSearchLogController $jobSearchLog
     * @return RedirectResponse
     */
    public function destroy(JobSearchLogController $jobSearchLog): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $jobSearchLog, $this->admin);

        $jobSearchLog->delete();

        return redirect(referer('admin.job-search-log.job-search-log.index'))
            ->with('success', 'Log entry deleted successfully.');
    }
}
