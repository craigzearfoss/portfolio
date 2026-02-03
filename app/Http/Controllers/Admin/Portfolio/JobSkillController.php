<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobSkillsRequest;
use App\Http\Requests\Portfolio\UpdateJobSkillsRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $perPage = $request->query('per_page', $this->perPage());

        if ($jobId = $request->job_id) {
            $job = !empty($this->owner)
                ? Job::where('owner_id', $this->owner->id)->where('id', $jobId)->first()
                : Job::find($jobId);
            if (empty($job)) {
                abort(404, 'Job ' . $jobId . ' not found'
                    . (!empty($this->owner) ? ' for ' . $this->owner->username : '') . '.');
            } else {
                $jobSkills = JobSkill::where('job_id', $jobId)->latest()->paginate($perPage);
            }
        } else {
            $job = null;
            $jobSkills = JobSkill::latest()->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Job Skills' : $this->owner->name . ' Job Skills';

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
        $jobId = $request->job_id;
        $job = !empty($jobId)
            ? Job::find($jobId)
            : null;

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
        $jobSkill = JobSkill::create($request->validated());

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
        list($prev, $next) = JobSkill::prevAndNextPages($jobSkill->id,
            'admin.portfolio.job-skill.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.job-skill.show', compact('jobSkill', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified job skill.
     *
     * @param JobSkill $jobSkill
     * @param Request $request
     * @return View
     */
    public function edit(JobSkill $jobSkill, Request $request): View
    {
        Gate::authorize('update-resource', $jobSkill);

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
        Gate::authorize('update-resource', $jobSkill);

        $jobSkill->update($request->validated());

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
        Gate::authorize('delete-resource', $jobSkill);

        $jobSkill->delete();

        return redirect(referer('admin.portfolio.job-skill.index'))
            ->with('success', $jobSkill->name . ' deleted successfully.');
    }
}
