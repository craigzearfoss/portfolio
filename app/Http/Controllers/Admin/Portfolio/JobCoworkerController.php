<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobCoworkersRequest;
use App\Http\Requests\Portfolio\UpdateJobCoworkersRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        readGate(JobCoworker::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $job = null;

        $jobCoworkerModel = new JobCoworker();

        $query = $jobCoworkerModel->orderBy('name');

        // get the job id, if one was specified
        if ($jobId = $request->get('job_id')) {
            $job = new Job()->findOrFail($jobId);
            $query->where('job_id', $jobId);
        }

        // get the current owner
        if ($ownerId = $request->get('owner_id')) {
            $owner = $jobCoworkerModel->findOrFail($ownerId);
        } elseif (!empty($this->owner)) {
            $owner = $this->owner;
        } else {
            $owner = null;
        }

        if (!empty($owner)) {
            if ($this->isRootAdmin) {
                $query->where('owner_id', '=', $owner->id);
            } elseif ($owner['id'] == $this->admin['id']) {
                $query->where('owner_id', '=', $owner->id);
            } else {
                $query->where('owner_id', '=', -1);
            }
        }

        $jobCoworkers = $query->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootAdmin() && !empty($ownerId)) ? $this->owner['name'] . ' Job Coworkers' : 'Job Coworkers';

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
        createGate(JobCoworker::class, $this->admin);

        if ($jobId = $request->query('job_id')) {
            $job = new Job()->find($jobId);
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
        createGate(JobCoworker::class, $this->admin);

        $jobCoworker = new JobCoworker()->create($request->validated());

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
        readGate($jobCoworker, $this->admin);

        list($prev, $next) = new JobCoworker()->prevAndNextPages(
            $jobCoworker['id'],
            'admin.portfolio.job-coworker.show',
            $this->owner ?? null,
            [ 'name', 'asc' ],
        );

        return view('admin.portfolio.job-coworker.show', compact('jobCoworker', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified job coworker.
     *
     * @param JobCoworker $jobCoworker
     * @return View
     */
    public function edit(JobCoworker $jobCoworker): View
    {
        updateGate($jobCoworker, $this->admin);

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
        $jobCoworker->update($request->validated());

        updateGate($jobCoworker, $this->admin);

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
        deleteGate($jobCoworker, $this->admin);

        $jobCoworker->delete();

        return redirect(referer('admin.portfolio.job-coworker.index'))
            ->with('success', $jobCoworker->name . ' deleted successfully.');
    }
}
