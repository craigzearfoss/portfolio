<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobTasksRequest;
use App\Http\Requests\Portfolio\UpdateJobTasksRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobTask;
use App\Models\System\Owner;
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
        readGate(PermissionEntityTypes::RESOURCE, 'job-task', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $jobTaskModel = new JobTask();

        if ($jobId = $request->job_id) {

            $job = new Job()->findOrFail($jobId);

            if ($this->isRootAdmin) {
                $query = $jobTaskModel->where('job_id', $jobId)
                    ->orderBy('job_id');
                if (($owner_id = $request->owner) && ($owner = new Owner()->findOrFail($owner_id))) {
                    $query->where('owner_id', $owner_id);
                }
            } elseif (!empty($this->owner)) {
                $query = $jobTaskModel->where('job_id', $jobId)
                    ->where('owner_id', $this->owner->id)
                    ->orderBy('job_id');
                $owner = $this->owner;
                $owner_id = $owner->id;
            }

            $jobTasks = $query->paginate($perPage)->appends(request()->except('page'));

        } else {

            $job = null;

            if ($this->isRootAdmin) {
                $query = $jobTaskModel->orderBy('job_id', 'desc');
                if (($owner_id = $request->owner_id) && ($owner = new Owner()->findOrFail($owner_id))) {
                    $query->where('owner_id', $owner_id);
                }
            } elseif (!empty($this->owner)) {
                $query = $jobTaskModel->where('owner_id', $this->owner->id)
                    ->orderBy('job_id', 'desc');
                $owner = $this->owner;
                $owner_id = $owner->id;
            }

            $jobTasks = $query->paginate($perPage)->appends(request()->except('page'));
        }

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Job Tasks' : 'Job Tasks';

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
        createGate(PermissionEntityTypes::RESOURCE, 'job-task', $this->admin);

        $jobId = $request->job_id;
        $job = !empty($jobId) ? new Job()->find($jobId) : null;

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
        createGate(PermissionEntityTypes::RESOURCE, 'jobTask', $this->admin);

        $jobTask = new JobTask()->create($request->validated());

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
        readGate(PermissionEntityTypes::RESOURCE, $jobTask, $this->admin);

        list($prev, $next) = new JobTask()->prevAndNextPages($jobTask->id,
            'admin.portfolio.job-task.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

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
        updateGate(PermissionEntityTypes::RESOURCE, $jobTask, $this->admin);

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

        updateGate(PermissionEntityTypes::RESOURCE, $jobTask, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $jobTask, $this->admin);

        $jobTask->delete();

        return redirect(referer('admin.portfolio.job-task.index'))
            ->with('success', 'Job task deleted successfully.');
    }
}
