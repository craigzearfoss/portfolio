<?php

namespace App\Http\Controllers\Admin\Career;

use App\Exports\Career\JobSearchLogsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreJobSearchLogsRequest;
use App\Models\Career\JobSearchLog;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class JobSearchLogController extends BaseAdminController
{
    /**
     * Display a listing of job search log entries.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(JobSearchLog::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $jobSearchLogs = new JobSearchLog()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobSearchLog::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Job Search Log';

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
        createGate(JobSearchLog::class, $this->admin);

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
        createGate(JobSearchLog::class, $this->admin);

        $logEntry = JobSearchLog::query()->create($request->validated());

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', 'Log entry successfully added.');
        } else {
            return redirect()->route('admin.career.job-search-log.show', $logEntry)
                ->with('success', 'Log entry successfully added.');
        }
    }

    /**
     * Display the specified job search log entry.
     *
     * @param JobSearchLog $jobSearchLog
     * @return View
     */
    public function show(JobSearchLog $jobSearchLog): View
    {
        readGate($jobSearchLog, $this->admin);

        list($prev, $next) = $jobSearchLog->prevAndNextPages(
            $jobSearchLog['id'],
            'admin.career.job-search-log.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.career.job-search-log.show', compact('jobSearchLog', 'prev', 'next'));
    }

    /**
     * Remove the specified job search log entry from storage.
     *
     * @param JobSearchLog $jobSearchLog
     * @return RedirectResponse
     */
    public function destroy(JobSearchLog $jobSearchLog): RedirectResponse
    {
        deleteGate($jobSearchLog, $this->admin);

        $jobSearchLog->delete();

        return redirect(referer('admin.job-search-log.job-search-log.index'))
            ->with('success', 'Log entry deleted successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $filename = request()->has('timestamp')
            ? 'job_search_log_' . date("Y-m-d-His") . '.xlsx'
            : 'job_search_log.xlsx';

        return Excel::download(new JobSearchLogsExport(), $filename);
    }
}
