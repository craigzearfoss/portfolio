<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StoreJobSkillRequest;
use App\Http\Requests\Portfolio\UpdateJobSkillRequest;
use App\Models\Portfolio\JobSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobSkillController extends Controller
{
    /**
     * Display a listing of job skills.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        if ($jobId = $request->query('job_id')) {
            $jobSkills = JobSkill::where('job_id', $jobId)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $jobSkills = JobSkill::orderBy('name', 'asc')->paginate($perPage);
        }

        return view('admin.portfolio.job-skill.index', compact('jobSkills', 'jobId'))
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
        if ($jobId = $request->query('job_id')) {
            $job = Job::find($jobId);
        } else {
            $job = null;
        }

        return view('admin.portfolio.job-skill.create', compact('job'));
    }

    /**
     * Store a newly created job skill in storage.
     *
     * @param StoreJobSkillRequest $storeJobSkillRequest
     * @return RedirectResponse
     */
    public function store(StoreJobSkillRequest $storeJobSkillRequest): RedirectResponse
    {
        $jobSkill = JobSkill::create($storeJobSkillRequest->validated());

        return redirect(referer('admin.portfolio.job-skill.index'))
            ->with('success', $jobSkill->name . ' added successfully.');
    }

    /**
     * Display the specified job skill.
     *
     * @param JobSkill $jobSkill
     * @return View
     */
    public function show(JobSkill $jobSkill): View
    {
        return view('admin.portfolio.job-skill.show', compact('jobSkill'));
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
        return view('admin.portfolio.job-skill.edit', compact('jobSkill'));
    }

    /**
     * Update the specified job skill in storage.
     *
     * @param UpdateJobSkillRequest $updateJobSkillRequest
     * @param JobSkill $jobSkill
     * @return RedirectResponse
     */
    public function update(UpdateJobSkillRequest $updateJobSkillRequest, JobSkill $jobSkill): RedirectResponse
    {
        $jobSkill->update($updateJobSkillRequest->validated());

        return redirect(referer('admin.portfolio.job-skill.index'))
            ->with('success', $jobSkill->name . ' updated successfully.');
    }

    /**
     * Remove the specified job skill from storage.
     *
     * @param JobSkill $jobSkill
     * @return RedirectResponse
     */
    public function destroy(JobSkill $jobSkill): RedirectResponse
    {
        $jobSkill->delete();

        return redirect(referer('admin.portfolio.job-skill.index'))
            ->with('success', $jobSkill->name . ' deleted successfully.');
    }
}
