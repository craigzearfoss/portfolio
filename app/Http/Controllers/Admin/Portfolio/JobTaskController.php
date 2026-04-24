<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobTasksRequest;
use App\Http\Requests\Portfolio\UpdateJobTasksRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobTask;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class JobTaskController extends BaseAdminController
{
    /**
     * Display a listing of job tasks.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(JobTask::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $job = null;
        $jobTasks = new JobTask()->searchQuery(
            request()->except('id', 'page', 'sort'),
            request()->input('sort') ?? implode('|', JobTask::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Job Tasks';

        return view('admin.portfolio.job-task.index', compact('jobTasks', 'job', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job task.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        createGate(JobTask::class, $this->admin);

        $jobId = $request->get('job_id');
        $job = !empty($jobId) ? Job::query()->find($jobId) : null;

        return view('admin.portfolio.job-task.create', compact('job'));
    }

    /**
     * Store a newly created job task in storage.
     *
     * @param StoreJobTasksRequest $request
     * @return RedirectResponse
     */
    public function store(StoreJobTasksRequest $request): RedirectResponse
    {
        createGate(JobTask::class, $this->admin);

        $jobTask = JobTask::query()->create($request->validated());

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', 'Job task successfully added.');
        } else {
            return redirect()->route('admin.portfolio.job-task.show', $jobTask)
                ->with('success', 'Job task successfully added.');
        }
    }

    /**
     * Display the specified job task.
     *
     * @param JobTask $jobTask
     * @return View
     */
    public function show(JobTask $jobTask): View
    {
        readGate($jobTask, $this->admin);

        list($prev, $next) = new JobTask()->prevAndNextPages(
            $jobTask['id'],
            'admin.portfolio.job-task.show',
            $this->owner->id ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.job-task.show', compact('jobTask', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified job task.
     *
     * @param JobTask $jobTask
     * @return View
     */
    public function edit(JobTask $jobTask): View
    {
        updateGate($jobTask, $this->admin);

        return view('admin.portfolio.job-task.edit', compact('jobTask'));
    }

    /**
     * Update the specified job task in storage.
     *
     * @param UpdateJobTasksRequest $request
     * @param JobTask $jobTask
     * @return RedirectResponse
     */
    public function update(UpdateJobTasksRequest $request, JobTask $jobTask): RedirectResponse
    {
        $jobTask->update($request->validated());

        updateGate($jobTask, $this->admin);

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', 'Job task successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.job-task.show', $jobTask)
                ->with('success', 'Job task successfully updated.');
        }
    }

    /**
     * Remove the specified job task from storage.
     *
     * @param JobTask $jobTask
     * @return RedirectResponse
     */
    public function destroy(JobTask $jobTask): RedirectResponse
    {
        deleteGate($jobTask, $this->admin);

        $jobTask->delete();

        return redirect(referer('admin.portfolio.job-task.index'))
            ->with('success', 'Job task deleted successfully.');
    }
}
