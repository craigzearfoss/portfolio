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
        $referer = $request->headers->get('referer');

        return view('admin.career.job.create', compact('referer'));
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
        $referer = $request->headers->get('referer');

        return view('admin.career.job.edit', compact('job', 'referer'));
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
        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('career_db.jobs', 'slug') ] ]);
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
     * @param Job $job
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Job $job, Request $request): RedirectResponse
    {
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
