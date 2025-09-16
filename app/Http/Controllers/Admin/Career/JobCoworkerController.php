<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\JobCoworkerStoreRequest;
use App\Http\Requests\Career\JobCoworkerUpdateRequest;
use App\Models\Career\Job;
use App\Models\Career\JobCoworker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobCoworkerController extends Controller
{
    /**
     * Display a listing of job coworkers.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        if ($jobId = $request->query('job_id')) {
            $jobCoworkers = JobCoworker::where('job_id', $jobId)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $jobCoworkers = JobCoworker::orderBy('name', 'asc')->paginate($perPage);
        }

        if ($jobId = $request->get('job_id')) {
            $job = Job::find($jobId);
        } else {
            $job = null;
        }

        return view('admin.career.job-coworker.index', compact('jobCoworkers', 'job'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job coworker.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job worker entries.');
        }

        return view('admin.career.job-coworker.create');
    }

    /**
     * Store a newly created job coworker in storage.
     */
    public function store(JobCoworkerStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job worker entries.');
        }

        JobCoworker::create($request->validated());

        return redirect()->route('admin.career.job-coworker.index')
            ->with('success', 'Job coworker created successfully.');
    }

    /**
     * Display the specified job coworker.
     */
    public function show(JobCoworker $jobCoworker): View
    {
        return view('admin.career.job-coworker.show', compact('jobCoworker'));
    }

    /**
     * Show the form for editing the specified job coworker.
     */
    public function edit(JobCoworker $jobCoworker, Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit job worker entries.');
        }

        return view('admin.career.job-coworker.edit', compact('jobCoworker'));
    }

    /**
     * Update the specified job coworker in storage.
     */
    public function update(JobCoworkerUpdateRequest $request, JobCoworker $jobCoworker): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update job worker entries.');
        }

        $jobCoworker->update($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect(str_replace(config('app.url'), '', $referer))->with('success', 'Job coworker updated successfully');
        } else {
            return redirect()->route('admin.career.job-coworker.index')
                ->with('success', 'Job coworker updated successfully');
        }
    }

    /**
     * Remove the specified job coworker from storage.
     */
    public function destroy(JobCoworker $jobCoworker): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete job worker entries.');
        }

        $jobCoworker->delete();

        return redirect()->route('admin.career.job-coworker.index')
            ->with('success', 'Job coworker deleted successfully');
    }
}
