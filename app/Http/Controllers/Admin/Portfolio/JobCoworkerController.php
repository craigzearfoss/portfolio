<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobCoworkersRequest;
use App\Http\Requests\Portfolio\UpdateJobCoworkersRequest;
use App\Models\Portfolio\Art;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobCoworker;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        readGate(PermissionEntityTypes::RESOURCE, 'job-coworker', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $jobCoworkerModel = new JobCoworker();

        $urlParams = $request->query();

        if ($jobId = $request->job_id) {

            $job = new Job()->findOrFail($jobId);

            if ($this->isRootAdmin) {
                $query = $jobCoworkerModel->where('job_id', $jobId)
                    ->orderBy('name');
                if (($owner_id = $urlParams['owner_id'] ?? null) && ($owner = new Owner()->findOrFail($owner_id))) {
                    $query->where('owner_id', $owner_id);
                }
            } elseif (!empty($this->owner)) {
                $query = $jobCoworkerModel->where('job_id', $jobId)
                    ->where('owner_id', $this->owner->id)
                    ->orderBy('name');
                $owner = $this->owner;
                $owner_id = $owner->id;
            }

        } else {

            $job = null;

            if ($this->isRootAdmin) {
                $query = $jobCoworkerModel->orderBy('name');
                if (($owner_id = $urlParams['owner_id'] ?? null) && ($owner = new Owner()->findOrFail($owner_id))) {
                    $query->where('owner_id', $owner_id);
                }
            } elseif (!empty($this->owner)) {
                $query = $jobCoworkerModel->where('owner_id', $this->owner->id)
                    ->orderBy('name');
                $owner = $this->owner;
                $owner_id = $owner->id;
            }
        }

        $jobCoworkers = $query->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $owner->name . ' Job Coworkers' : 'Job Coworkers';

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
        createGate(PermissionEntityTypes::RESOURCE, 'job-cowroker', $this->admin);

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
        createGate(PermissionEntityTypes::RESOURCE, 'jobCoworker', $this->admin);

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
        readGate(PermissionEntityTypes::RESOURCE, $jobCoworker, $this->admin);

        list($prev, $next) = new JobCoworker()->prevAndNextPages($jobCoworker->id,
            'admin.portfolio.job-coworker.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.job-coworker.show', compact('jobCoworker', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified job coworker.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $jobCoworker = new JobCoworker()->findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $jobCoworker, $this->admin);

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

        updateGate(PermissionEntityTypes::RESOURCE, $jobCoworker, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $jobCoworker, $this->admin);

        $jobCoworker->delete();

        return redirect(referer('admin.portfolio.job-coworker.index'))
            ->with('success', $jobCoworker->name . ' deleted successfully.');
    }
}
