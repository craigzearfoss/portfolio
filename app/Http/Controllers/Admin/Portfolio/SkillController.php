<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreSkillsRequest;
use App\Http\Requests\Portfolio\UpdateSkillsRequest;
use App\Models\Portfolio\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class SkillController extends BaseAdminController
{
    /**
     * Display a listing of skills.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $skills = Skill::orderBy('level', 'desc')->orderBy('featured', 'desc')
            ->orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.skill.index', compact('skills'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new skill.
     *
     * @return View
     */
    public function create(Request $request): View
    {
        return view('admin.portfolio.skill.create');
    }

    /**
     * Store a newly created skill in storage.
     *
     * @param StoreSkillsRequest $storeSkillsRequest
     * @return RedirectResponse
     */
    public function store(StoreSkillsRequest $storeSkillsRequest): RedirectResponse
    {
        $skill = Skill::create($storeSkillsRequest->validated());

        return redirect()->route('admin.portfolio.skill.show', $skill)
            ->with('success', $skill->name . ' successfully added.');
    }

    /**
     * Display the specified skill.
     *
     * @param Skill $skill
     * @return View
     */
    public function show(Skill $skill): View
    {
        return view('admin.portfolio.skill.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified skill.
     *
     * @param Skill $skill
     * @return View
     */
    public function edit(Skill $skill): View
    {
        return view('admin.portfolio.skill.edit', compact('skill'));
    }

    /**
     * Update the specified skill in storage.
     *
     * @param UpdateSkillsRequest $updateSkillsRequest
     * @param Skill $skill
     * @return RedirectResponse
     */
    public function update(UpdateSkillsRequest $updateSkillsRequest, Skill $skill): RedirectResponse
    {
        $skill->update($updateSkillsRequest->validated());

        return redirect()->route('admin.portfolio.skill.show', $skill)
            ->with('success', $skill->name . ' successfully updated.');
    }

    /**
     * Remove the specified skill from storage.
     *
     * @param Skill $skill
     * @return RedirectResponse
     */
    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect(referer('admin.portfolio.skill.index'))
            ->with('success', $skill->name . ' deleted successfully.');
    }
}
