<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\JobStoreRequest;
use App\Http\Requests\Portfolio\JobUpdateRequest;
use App\Models\Portfolio\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class JobController extends BaseController
{
    /**
     * Display a listing of jobs.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $jobs = Job::orderBy('start_year', 'desc')->orderBy('start_month', 'desc')->paginate($perPage);

        return view('admin.portfolio.job.index', compact('jobs'))
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
     * @param JobStoreRequest $jobStoreRequest
     * @return RedirectResponse
     */
    public function store(JobStoreRequest $jobStoreRequest): RedirectResponse
    {
        $job = Job::create($jobStoreRequest->validated());

        return redirect(referer('admin.portfolio.job.index'))
            ->with('success', $job->company . ' job added successfully.');
    }

    /**
     * Display the specified job.
     *
     * @param Job $job
     * @return View
     */
    public function show(Job $job): View
    {
        return view('admin.portfolio.job.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job.
     *
     * @param Job $job
     * @param Request $request
     * @return View
     */
    public function edit(Job $job, Request $request): View
    {
        return view('admin.portfolio.job.edit', compact('job'));
    }

    /**
     * Update the specified job in storage.
     *
     * @param JobUpdateRequest $request
     * @param Job $job
     * @return RedirectResponse
     */
    public function update(JobUpdateRequest $request, Job $job): RedirectResponse
    {
        $job->update($request->validated());

        return redirect(referer('admin.portfolio.job.index'))
            ->with('success', $job->company . ' job updated successfully.');
    }

    /**
     * Remove the specified job from storage.
     *
     * @param Job $job
     * @return RedirectResponse
     */
    public function destroy(Job $job): RedirectResponse
    {
        $job->delete();

        return redirect(referer('admin.portfolio.job.index'))
            ->with('success', $job->company . ' job deleted successfully.');
    }
}
