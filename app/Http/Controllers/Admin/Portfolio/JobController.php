<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobsRequest;
use App\Http\Requests\Portfolio\UpdateJobsRequest;
use App\Models\Portfolio\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class JobController extends BaseAdminController
{
    /**
     * Display a listing of jobs.
     *
     * @param Request $request
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'job', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $jobs = Job::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $jobs = Job::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Jobs' : $this->owner->name . ' jobs';

        return view('admin.portfolio.job.index', compact('jobs', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.job.create');
    }

    /**
     * Store a newly created job in storage.
     *
     * @param StoreJobsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreJobsRequest $request): RedirectResponse
    {
        $job = Job::create($request->validated());

        return redirect()->route('admin.portfolio.job.show', $job)
            ->with('success', $job->company . ' job successfully added.');
    }

    /**
     * Display the specified job.
     *
     * @param Job $job
     * @return View
     */
    public function show(Job $job): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $job, $this->admin);

        list($prev, $next) = Job::prevAndNextPages($job->id,
            'admin.portfolio.job.show',
            $this->owner->id ?? null,
            ['company', 'asc']);

        return view('admin.portfolio.job.show', compact('job', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified job.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $job = Job::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $job, $this->admin);

        return view('admin.portfolio.job.edit', compact('job'));
    }

    /**
     * Update the specified job in storage.
     *
     * @param UpdateJobsRequest $request
     * @param Job $job
     * @return RedirectResponse
     */
    public function update(UpdateJobsRequest $request, Job $job): RedirectResponse
    {
        $job->update($request->validated());

        return redirect()->route('admin.portfolio.job.show', $job)
            ->with('success', $job->company . ' job successfully updated.');
    }

    /**
     * Remove the specified job from storage.
     *
     * @param Job $job
     * @return RedirectResponse
     */
    public function destroy(Job $job): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $job, $this->admin);

        $job->delete();

        return redirect(referer('admin.portfolio.job.index'))
            ->with('success', $job->company . ' job deleted successfully.');
    }
}
