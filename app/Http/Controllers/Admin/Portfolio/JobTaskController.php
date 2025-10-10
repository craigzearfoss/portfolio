<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobTaskRequest;
use App\Http\Requests\Portfolio\UpdateJobTaskRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobTask;
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
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        if ($jobId = $request->query('job_id')) {
	        $jobTasks = JobTask::where('job_id', $jobId)->orderBy('job_id', 'asc')->orderBy('sequence', 'asc')->paginate($perPage);
        } else {
            $jobTasks = JobTask::orderBy('job_id', 'asc')->orderBy('sequence', 'asc')->paginate($perPage);
        }

        return view('admin.portfolio.job-task.index', compact('jobTasks', 'jobId'))
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
        if ($jobId = $request->query('job_id')) {
            $job = Job::find($jobId);
        } else {
            $job = null;
        }

        return view('admin.portfolio.job-task.create', compact('job'));
    }

    /**
     * Store a newly created job task in storage.
     *
     * @param StoreJobTaskRequest $updateJobTaskStoreRequest
     * @return RedirectResponse
     */
    public function store(StoreJobTaskRequest $updateJobTaskStoreRequest): RedirectResponse
    {
        $jobTask = JobTask::create($updateJobTaskStoreRequest->validated());

        return redirect(referer('admin.portfolio.job-task.index'))
            ->with('success', 'Job task added successfully.');
    }

    /**
     * Display the specified job task.
     *
     * @param JobTask $jobTask
     * @return View
     */
    public function show(JobTask $jobTask): View
    {
        return view('admin.portfolio.job-task.show', compact('jobTask'));
    }

    /**
     * Show the form for editing the specified job task.
     *
     * @param JobTask $jobTask
     * @param Request $request
     * @return View
     */
    public function edit(JobTask $jobTask, Request $request): View
    {
        return view('admin.portfolio.job-task.edit', compact('jobTask'));
    }

    /**
     * Update the specified job task in storage.
     *
     * @param UpdateJobTaskRequest $updateJobTaskRequest
     * @param JobTask $jobTask
     * @return RedirectResponse
     */
    public function update(UpdateJobTaskRequest $updateJobTaskRequest, JobTask $jobTask): RedirectResponse
    {
        $jobTask->update($updateJobTaskRequest->validated());

        return redirect(referer('admin.portfolio.job-task.index'))
            ->with('success', 'Job task updated successfully.');
    }

    /**
     * Remove the specified job task from storage.
     *
     * @param JobTask $jobTask
     * @return RedirectResponse
     */
    public function destroy(JobTask $jobTask): RedirectResponse
    {
        $jobTask->delete();

        return redirect(referer('admin.portfolio.job-task.index'))
            ->with('success', 'Job task deleted successfully.');
    }
}
