<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobTasksRequest;
use App\Http\Requests\Portfolio\UpdateJobTasksRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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

        $jobId = $request->job_id;
        if (!empty($jobId)) {
            $job = Job::find($jobId);
            $jobTasks = JobTask::where('job_id', $jobId)->latest()->paginate($perPage);
        } else {
            $job = null;
            $jobTasks = JobTask::latest()->paginate($perPage);
        }

        return view('admin.portfolio.job-task.index', compact('jobTasks', 'job'))
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
     * @param StoreJobTasksRequest $updateJobTaskStoreRequest
     * @return RedirectResponse
     */
    public function store(StoreJobTasksRequest $updateJobTaskStoreRequest): RedirectResponse
    {
        $jobTask = JobTask::create($updateJobTaskStoreRequest->validated());

        return redirect()->route('admin.portfolio.job-task.show', $jobTask)
            ->with('success', 'Job task successfully added.');
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
        Gate::authorize('update-resource', $jobTask);

        return view('admin.portfolio.job-task.edit', compact('jobTask'));
    }

    /**
     * Update the specified job task in storage.
     *
     * @param UpdateJobTasksRequest $updateJobTasksRequest
     * @param JobTask $jobTask
     * @return RedirectResponse
     */
    public function update(UpdateJobTasksRequest $updateJobTasksRequest, JobTask $jobTask): RedirectResponse
    {
        Gate::authorize('update-resource', $jobTask);

        $jobTask->update($updateJobTasksRequest->validated());

        return redirect()->route('admin.portfolio.job-task.show', $jobTask)
            ->with('success', 'Job task successfully updated.');
    }

    /**
     * Remove the specified job task from storage.
     *
     * @param JobTask $jobTask
     * @return RedirectResponse
     */
    public function destroy(JobTask $jobTask): RedirectResponse
    {
        Gate::authorize('delete-resource', $jobTask);

        $jobTask->delete();

        return redirect(referer('admin.portfolio.job-task.index'))
            ->with('success', 'Job task deleted successfully.');
    }
}
