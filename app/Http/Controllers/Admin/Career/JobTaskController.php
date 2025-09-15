<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\JobTaskStoreRequest;
use App\Http\Requests\Career\JobTaskUpdateRequest;
use App\Models\Career\JobTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobTaskController extends Controller
{
    /**
     * Display a listing of job tasks.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $jobTasks = JobTask::latest()->paginate($perPage);

        return view('admin.career.job-task.index', compact('jobTasks'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job task.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job worker entries.');
        }

        return view('admin.career.job-task.create');
    }

    /**
     * Store a newly created job task in storage.
     */
    public function store(JobTaskStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add job worker entries.');
        }

        JobTask::create($request->validated());

        return redirect()->route('admin.career.job-task.index')
            ->with('success', 'Job task created successfully.');
    }

    /**
     * Display the specified job task.
     */
    public function show(JobTask $jobTask): View
    {
        return view('admin.career.job-task.show', compact('jobTask'));
    }

    /**
     * Show the form for editing the specified job task.
     */
    public function edit(JobTask $jobTask): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit job worker entries.');
        }

        return view('admin.career.job-task.edit', compact('jobTask'));
    }

    /**
     * Update the specified job task in storage.
     */
    public function update(JobTaskUpdateRequest $request, JobTask $jobTask): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update job worker entries.');
        }

        $jobTask->update($request->validated());

        return redirect()->route('admin.career.job-task.index')
            ->with('success', 'Job task updated successfully');
    }

    /**
     * Remove the specified job task from storage.
     */
    public function destroy(JobTask $jobTask): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete job worker entries.');
        }

        $jobTask->delete();

        return redirect()->route('admin.career.job-task.index')
            ->with('success', 'Job task deleted successfully');
    }
}
