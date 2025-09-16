<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\JobStoreRequest;
use App\Http\Requests\Career\JobUpdateRequest;
use App\Models\Career\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $perPage= $request->query('per_page', $this->perPage);

        $jobs = Job::latest()->paginate($perPage);

        return view('admin.career.job.index', compact('jobs'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job entries.');
        }

        $referer = Request()->headers->get('referer');

        return view('admin.career.job.create', compact('referer'));
    }

    /**
     * Store a newly created job in storage.
     *
     * @param JobTaskStoreRequest $request
     * @return RedirectResponse
     */
    public function store(JobStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job entries.');
        }

        $job = Job::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $job->company . ' job created successfully.');
        } else {
            return redirect()->route('admin.career.job.index')
                ->with('success', $job->company . ' job created successfully.');
        }
    }

    /**
     * Display the specified job.
     *
     * @param JobCoworker $jobCoworker
     * @return View
     */
    public function show(Job $job): View
    {
        return view('admin.career.job.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job.
     *
     * @param JobCoworker $jobCoworker
     * @param Request $request
     * @return View
     */
    public function edit(Job $job, Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit job entries.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.career.job.edit', compact('job', 'referer'));
    }

    /**
     * Update the specified job in storage.
     *
     * @param JobCoworkerUpdateRequest $request
     * @param JobCoworker $jobCoworker
     * @return RedirectResponse
     */
    public function update(JobUpdateRequest $request, Job $job): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update job entries.');
        }

        $job->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $job->company . ' job updated successfully.');
        } else {
            return redirect()->route('admin.career.job.index')
                ->with('success', $job->company . ' job successfully');
        }
    }

    /**
     * Remove the specified job from storage.
     *
     * @param JobCoworker $jobCoworker
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Job $job, Request $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete job entries.');
        }

        $job->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $job->company . ' job deleted successfully.');
        } else {
            return redirect()->route('admin.career.job.index')
                ->with('success', $job->company . ' job deleted successfully');
        }
    }
}
