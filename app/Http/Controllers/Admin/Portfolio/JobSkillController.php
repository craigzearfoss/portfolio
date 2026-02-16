<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobSkillsRequest;
use App\Http\Requests\Portfolio\UpdateJobSkillsRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobSkill;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class JobSkillController extends BaseAdminController
{
    /**
     * Display a listing of job skills.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'job-skill', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $jobSkillModel = new JobSkill();

        if ($jobId = $request->job_id) {

            $job = new Job()->findOrFail($jobId);

            if ($this->isRootAdmin) {
                $query = $jobSkillModel->where('job_id', $jobId)
                    ->orderBy('name');
                if (($owner_id = $request->owner) && ($owner = new Owner()->findOrFail($owner_id))) {
                    $query->where('owner_id', $owner_id);
                }
            } elseif (!empty($this->owner)) {
                $query = $jobSkillModel->where('job_id', $jobId)
                    ->where('owner_id', $this->owner->id)
                    ->orderBy('name');
                $owner = $this->owner;
                $owner_id = $owner->id;
            }

            $jobSkills = $query->paginate($perPage)->appends(request()->except('page'));

        } else {

            $job = null;

            if ($this->isRootAdmin) {
                $query = $jobSkillModel->orderBy('name');
                if (($owner_id = $request->owner_id) && ($owner = new Owner()->findOrFail($owner_id))) {
                    $query->where('owner_id', $owner_id);
                }
            } elseif (!empty($this->owner)) {
                $query = $jobSkillModel->where('owner_id', $this->owner->id)
                    ->orderBy('name');
                $owner = $this->owner;
                $owner_id = $owner->id;
            }

            $jobSkills = $query->paginate($perPage)->appends(request()->except('page'));
        }

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Job Skills' : 'Job Skills';

        return view('admin.portfolio.job-skill.index', compact('jobSkills', 'job', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new job skill.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'job-skill', $this->admin);

        $jobId = $request->job_id;
        $job = !empty($jobId) ? new Job()->find($jobId) : null;

        return view('admin.portfolio.job-skill.create', compact('job'));
    }

    /**
     * Store a newly created job skill in storage.
     *
     * @param StoreJobSkillsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreJobSkillsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'jobSkill', $this->admin);

        $jobSkill = new JobSkill()->create($request->validated());

        return redirect()->route('admin.portfolio.job-skill.show', $jobSkill)
            ->with('success', $jobSkill->name . ' successfully added.');
    }

    /**
     * Display the specified job skill.
     *
     * @param JobSkill $jobSkill
     * @return View
     */
    public function show(JobSkill $jobSkill): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $jobSkill, $this->admin);

        list($prev, $next) = new JobSkill()->prevAndNextPages($jobSkill->id,
            'admin.portfolio.job-skill.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.job-skill.show', compact('jobSkill', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified job skill.
     *
     * @param JobSkill $jobSkill
     * @return View
     */
    public function edit(JobSkill $jobSkill): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $jobSkill, $this->admin);

        return view('admin.portfolio.job-skill.edit', compact('jobSkill'));
    }

    /**
     * Update the specified job skill in storage.
     *
     * @param UpdateJobSkillsRequest $request
     * @param JobSkill $jobSkill
     * @return RedirectResponse
     */
    public function update(UpdateJobSkillsRequest $request, JobSkill $jobSkill): RedirectResponse
    {
        $jobSkill->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $jobSkill, $this->admin);

        return redirect()->route('admin.portfolio.job-skill.show', $jobSkill)
            ->with('success', $jobSkill->name . ' successfully updated.');
    }

    /**
     * Remove the specified job skill from storage.
     *
     * @param JobSkill $jobSkill
     * @return RedirectResponse
     */
    public function destroy(JobSkill $jobSkill): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $jobSkill, $this->admin);

        $jobSkill->delete();

        return redirect(referer('admin.portfolio.job-skill.index'))
            ->with('success', $jobSkill->name . ' deleted successfully.');
    }
}
