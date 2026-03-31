<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobSkillsRequest;
use App\Http\Requests\Portfolio\UpdateJobSkillsRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        readGate(JobSkill::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        // by default, root admins display all job skills
        $owner = ($this->owner && ($this->owner['id'] !== $this->admin['id'])) ? $this->owner : null;

        $jobSkillModel = new JobSkill();

        $job = null;
        $jobSkills = $jobSkillModel->searchQuery(request()->except('id'), $owner)
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($owner->name  ?? '') . ' Job Skills';

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
        createGate(JobSkill::class, $this->admin);

        $jobId = $request->get('job_id');
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
        createGate(JobSKill::class, $this->admin);

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
        readGate($jobSkill, $this->admin);

        list($prev, $next) = new JobSkill()->prevAndNextPages(
            $jobSkill['id'],
            'admin.portfolio.job-skill.show',
            $this->owner->id ?? null,
            [ 'name', 'asc' ]
        );

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
        updateGate($jobSkill, $this->admin);

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

        updateGate($jobSkill, $this->admin);

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
        deleteGate($jobSkill, $this->admin);

        $jobSkill->delete();

        return redirect(referer('admin.portfolio.job-skill.index'))
            ->with('success', $jobSkill->name . ' deleted successfully.');
    }
}
