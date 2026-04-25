<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Exports\Portfolio\JobSkillsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreJobSkillsRequest;
use App\Http\Requests\Portfolio\UpdateJobSkillsRequest;
use App\Models\Portfolio\Job;
use App\Models\Portfolio\JobSkill;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(JobSkill::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $job = null;
        $jobSkills = new JobSkill()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobSkill::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Job Skills';

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

        $jobId = $request->input('job_id');
        $job = !empty($jobId) ? Job::query()->find($jobId) : null;

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

        $jobSkill = JobSkill::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $jobSkill['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.portfolio.job-skill.show', $jobSkill)
                ->with('success', $jobSkill['name'] . ' successfully added.');
        }
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

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $jobSkill['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.job-skill.show', $jobSkill)
                ->with('success', $jobSkill['name'] . ' successfully updated.');
        }
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
            ->with('success', $jobSkill['name'] . ' deleted successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $filename = request()->has('timestamp')
            ? 'job_skills_' . date("Y-m-d-His") . '.xlsx'
            : 'job_skills.xlsx';

        return Excel::download(new JobSkillsExport(), $filename);
    }
}
