<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\JobStoreRequest;
use App\Http\Requests\Career\JobUpdateRequest;
use App\Models\Career\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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

        $jobs = Job::latest()->paginate($perPage);

        return view('admin.career.job.index', compact('jobs'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.job.create');
    }

    /**
     * Store a newly created job in storage.
     *
     * @param JobStoreRequest $request
     * @return RedirectResponse
     */
    public function store(JobStoreRequest $request): RedirectResponse
    {
        $job = Job::create($request->validated());

        return redirect(referer('admin.career.job.index'))
            ->with('success', $job->company . ' job created successfully.');
    }

    /**
     * Display the specified job.
     *
     * @param Job $job
     * @return View
     */
    public function show(Job $job): View
    {
        return view('admin.career.job.show', compact('job'));
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
        return view('admin.career.job.edit', compact('job'));
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

        return redirect(referer('admin.career.job.index'))
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

        return redirect(referer('admin.career.job.index'))
            ->with('success', $job->company . ' job deleted successfully.');
    }
}
