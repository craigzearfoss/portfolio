<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\JobTaskStoreRequest;
use App\Http\Requests\Career\JobTaskUpdateRequest;
use App\Models\Career\JobTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class JobTaskController extends BaseController
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

        return view('admin.career.job-task.index', compact('jobTasks', 'jobId'))
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
        $jobId = $request->query('job_id');

        return view('admin.career.job-task.create', compact('jobId'));
    }

    /**
     * Store a newly created job task in storage.
     *
     * @param JobTaskStoreRequest $request
     * @return RedirectResponse
     */
    public function store(JobTaskStoreRequest $request): RedirectResponse
    {
        $jobTask = JobTask::create($request->validated());

        return redirect(referer('admin.career.job-task.index'))
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
        return view('admin.career.job-task.show', compact('jobTask'));
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
        return view('admin.career.job-task.edit', compact('jobTask'));
    }

    /**
     * Update the specified job task in storage.
     *
     * @param JobTaskUpdateRequest $request
     * @param JobTask $jobTask
     * @return RedirectResponse
     */
    public function update(JobTaskUpdateRequest $request, JobTask $jobTask): RedirectResponse
    {
        $jobTask->update($request->validated());

        return redirect(referer('admin.career.job-task.index'))
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

        return redirect(referer('admin.career.job-task.index'))
            ->with('success', 'Job task deleted successfully.');
    }
}
