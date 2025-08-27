<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerJobStoreRequest;
use App\Http\Requests\CareerJobUpdateRequest;
use App\Models\Career\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CareerJobController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of jobs.
     */
    public function index(): View
    {
        $jobs = Job::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.job.index', compact('jobs'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new job.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job board entries.');
        }

        return view('admin.job.create');
    }

    /**
     * Store a newly created job in storage.
     */
    public function store(CareerJobStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job board entries.');
        }

        Job::create($request->validated());

        return redirect()->route('admin.job.index')
            ->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified job.
     */
    public function show(Job $job): View
    {
        return view('admin.job.show', compact('job'));
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(Job $job): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit job board entries.');
        }

        return view('admin.job.edit', compact('job'));
    }

    /**
     * Update the specified job in storage.
     */
    public function update(CareerJobUpdateRequest $request, Job $job): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update job board entries.');
        }

        $job->update($request->validated());

        return redirect()->route('admin.job.index')
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

        return redirect()->route('admin.job.index')
            ->with('success', 'Job deleted successfully');
    }
}
