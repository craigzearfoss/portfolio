<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\StoreJobCoworkerRequest;
use App\Http\Requests\Portfolio\UpdateJobCoworkerRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class JobCoworkerController extends BaseController
{
    /**
     * Display a listing of job coworkers.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        if ($jobId = $request->query('job_id')) {
            $jobCoworkers = JobCoworker::where('job_id', $jobId)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $jobCoworkers = JobCoworker::orderBy('name', 'asc')->paginate($perPage);
        }

        return view('admin.portfolio.job-coworker.index', compact('jobCoworkers', 'jobId'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job coworker.
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

        return view('admin.portfolio.job-coworker.create', compact('job'));
    }

    /**
     * Store a newly created job coworker in storage.
     *
     * @param StoreJobCoworkerRequest $storeJobCoworkerRequest
     * @return RedirectResponse
     */
    public function store(StoreJobCoworkerRequest $storeJobCoworkerRequest): RedirectResponse
    {
        $jobCoworker = JobCoworker::create($storeJobCoworkerRequest->validated());

        return redirect(referer('admin.portfolio.job-coworker.index'))
            ->with('success', $jobCoworker->name . ' added successfully.');
    }

    /**
     * Display the specified job coworker.
     *
     * @param JobCoworker $jobCoworker
     * @return View
     */
    public function show(JobCoworker $jobCoworker): View
    {
        return view('admin.portfolio.job-coworker.show', compact('jobCoworker'));
    }

    /**
     * Show the form for editing the specified job coworker.
     *
     * @param JobCoworker $jobCoworker
     * @param Request $request
     * @return View
     */
    public function edit(JobCoworker $jobCoworker, Request $request): View
    {
        return view('admin.portfolio.job-coworker.edit', compact('jobCoworker'));
    }

    /**
     * Update the specified job coworker in storage.
     *
     * @param UpdateJobCoworkerRequest $updateJobCoworkerRequest
     * @param JobCoworker $jobCoworker
     * @return RedirectResponse
     */
    public function update(UpdateJobCoworkerRequest $updateJobCoworkerRequest, JobCoworker $jobCoworker): RedirectResponse
    {
        $jobCoworker->update($updateJobCoworkerRequest->validated());

        return redirect(referer('admin.portfolio.job-coworker.index'))
            ->with('success', $jobCoworker->name . ' updated successfully.');
    }

    /**
     * Remove the specified job coworker from storage.
     *
     * @param JobCoworker $jobCoworker
     * @return RedirectResponse
     */
    public function destroy(JobCoworker $jobCoworker): RedirectResponse
    {
        $jobCoworker->delete();

        return redirect(referer('admin.portfolio.job-coworker.index'))
            ->with('success', $jobCoworker->name . ' deleted successfully.');
    }
}
