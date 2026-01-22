<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobCoworkersRequest;
use App\Http\Requests\Portfolio\UpdateJobCoworkersRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class JobCoworkerController extends BaseAdminController
{
    /**
     * Display a listing of job coworkers.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        if ($jobId = $request->job_id) {
            $job = !empty($this->owner)
                ? Job::where('owner_id', $this->owner->id)->where('id', $jobId)->first()
                : Job::find($jobId);
            if (empty($job)) {
                abort(404, 'Job ' . $jobId . ' not found'
                    . (!empty($this->owner) ? ' for ' . $this->owner->username : '') . '.');
            } else {
                $jobCoworkers = JobCoworker::where('job_id', $jobId)->latest()->paginate($perPage);
            }
        } else {
            $job = null;
            $jobCoworkers = JobCoworker::latest()->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Job Coworkers' : $this->owner->name . ' Job Coworkers';

        return view('admin.portfolio.job-coworker.index', compact('jobCoworkers', 'job', 'pageTitle'))
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
     * @param StoreJobCoworkersRequest $request
     * @return RedirectResponse
     */
    public function store(StoreJobCoworkersRequest $request): RedirectResponse
    {
        $jobCoworker = JobCoworker::create($request->validated());

        return redirect()->route('admin.portfolio.job-coworker.show', $jobCoworker)
            ->with('success', $jobCoworker->name . ' successfully added.');
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
        Gate::authorize('update-resource', $jobCoworker);

        return view('admin.portfolio.job-coworker.edit', compact('jobCoworker'));
    }

    /**
     * Update the specified job coworker in storage.
     *
     * @param UpdateJobCoworkersRequest $request
     * @param JobCoworker $jobCoworker
     * @return RedirectResponse
     */
    public function update(UpdateJobCoworkersRequest $request, JobCoworker $jobCoworker): RedirectResponse
    {
        Gate::authorize('update-resource', $jobCoworker);

        $jobCoworker->update($request->validated());

        return redirect()->route('admin.portfolio.job-coworker.show', $jobCoworker)
            ->with('success', $jobCoworker->name . ' successfully updated.');
    }

    /**
     * Remove the specified job coworker from storage.
     *
     * @param JobCoworker $jobCoworker
     * @return RedirectResponse
     */
    public function destroy(JobCoworker $jobCoworker): RedirectResponse
    {
        Gate::authorize('delete-resource', $jobCoworker);

        $jobCoworker->delete();

        return redirect(referer('admin.portfolio.job-coworker.index'))
            ->with('success', $jobCoworker->name . ' deleted successfully.');
    }
}
