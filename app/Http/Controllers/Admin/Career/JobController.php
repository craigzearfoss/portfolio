<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\JobStoreRequest;
use App\Http\Requests\Career\obUpdateRequest;
use App\Models\Career\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobController extends Controller
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
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job board entries.');
        }

        return view('admin.career.job.create');
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(JobStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job board entries.');
        }

        Job::create($request->validated());

        return redirect()->route('admin.career.job.index')
            ->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified job.
     */
    public function show(Job $job): View
    {
        return view('admin.career.job.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(Job $job): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit job board entries.');
        }

        return view('admin.career.job.edit', compact('job'));
    }

    /**
     * Update the specified job in storage.
     */
    public function update(obUpdateRequest $request, Job $job): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update job board entries.');
        }

        $job->update($request->validated());

        return redirect()->route('admin.career.job.index')
            ->with('success', 'Job updated successfully');
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy(Job $job): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete job board entries.');
        }

        $job->delete();

        return redirect()->route('admin.career.job.index')
            ->with('success', 'Job deleted successfully');
    }
}
