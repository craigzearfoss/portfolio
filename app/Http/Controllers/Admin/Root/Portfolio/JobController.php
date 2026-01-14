<?php

namespace App\Http\Controllers\Admin\Root\Portfolio;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Http\Requests\Portfolio\StoreJobsRequest;
use App\Http\Requests\Portfolio\UpdateJobsRequest;
use App\Models\Portfolio\Job;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class JobController extends BaseAdminRootController
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
        $resource = Resource::where('database_id', Database::where('tag', 'portfolio_db')->first()->id)
            ->where('name', 'job')->first();

        return view('admin.portfolio.job.index', compact('jobs', 'resource'))
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
     * @param StoreJobsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreJobsRequest $request): RedirectResponse
    {
        $job = Job::create($request->validated());

        return redirect()->route('root.portfolio.job.show', $job)
            ->with('success', $job->company . ' job successfully added.');
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
        Gate::authorize('update-resource', $job);

        return view('admin.portfolio.job.edit', compact('job'));
    }

    /**
     * Update the specified job in storage.
     *
     * @param UpdateJobsRequest $request
     * @param Job $job
     * @return RedirectResponse
     */
    public function update(UpdateJobsRequest $request, Job $job): RedirectResponse
    {
        Gate::authorize('update-resource', $job);

        $job->update($request->validated());

        return redirect()->route('root.portfolio.job.show', $job)
            ->with('success', $job->company . ' job successfully updated.');
    }

    /**
     * Remove the specified job from storage.
     *
     * @param Job $job
     * @return RedirectResponse
     */
    public function destroy(Job $job): RedirectResponse
    {
        Gate::authorize('delete-resource', $job);

        $job->delete();

        return redirect(referer('root.portfolio.job.index'))
            ->with('success', $job->company . ' job deleted successfully.');
    }
}
