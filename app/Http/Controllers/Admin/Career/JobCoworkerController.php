<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\JobCoworkerStoreRequest;
use App\Http\Requests\Career\JobCoworkerUpdateRequest;
use App\Models\Career\JobCoworker;
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

        return view('admin.career.job-coworker.index', compact('jobCoworkers', 'jobId'))
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
        $jobId = $request->query('job_id');

        return view('admin.career.job-coworker.create', compact('jobId'));
    }

    /**
     * Store a newly created job coworker in storage.
     *
     * @param JobCoworkerStoreRequest $request
     * @return RedirectResponse
     */
    public function store(JobCoworkerStoreRequest $request): RedirectResponse
    {
        $jobCoworker = JobCoworker::create($request->validated());

        return redirect(referer('admin.career.job-coworker.index'))
            ->with('success', $jobCoworker->name . ' created successfully.');
    }

    /**
     * Display the specified job coworker.
     *
     * @param JobCoworker $jobCoworker
     * @return View
     */
    public function show(JobCoworker $jobCoworker): View
    {
        return view('admin.career.job-coworker.show', compact('jobCoworker'));
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
        return view('admin.career.job-coworker.edit', compact('jobCoworker'));
    }

    /**
     * Update the specified job coworker in storage.
     *
     * @param JobCoworkerUpdateRequest $request
     * @param JobCoworker $jobCoworker
     * @return RedirectResponse
     */
    public function update(JobCoworkerUpdateRequest $request, JobCoworker $jobCoworker): RedirectResponse
    {
        $jobCoworker->update($request->validated());

        return redirect(referer('admin.career.job-coworker.index'))
            ->with('success', $jobCoworker->name . ' updated successfully.');
    }

    /**
     * Remove the specified job coworker from storage.
     *
     * @param JobCoworker $jobCoworker
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(JobCoworker $jobCoworker, Request $request): RedirectResponse
    {
        $jobCoworker->delete();

        return redirect(referer('admin.career.job-coworker.index'))
            ->with('success', $jobCoworker->name . ' deleted successfully.');
    }
}
