<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\SkillStoreRequest;
use App\Http\Requests\Portfolio\SkillUpdateRequest;
use App\Models\Portfolio\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class SkillController extends BaseController
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
     * @param SkillStoreRequest $skillStoreRequest
     * @return RedirectResponse
     */
    public function store(SkillStoreRequest $skillStoreRequest): RedirectResponse
    {
        $skill = Skill::create($skillStoreRequest->validated());

        return redirect(referer('admin.portfolio.skill.index'))
            ->with('success', $skill->name . ' added successfully.');
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
     * @param SkillUpdateRequest $skillUpdateRequest
     * @param Skill $skill
     * @return RedirectResponse
     */
    public function update(SkillUpdateRequest $skillUpdateRequest, Skill $skill): RedirectResponse
    {
        $skill->update($skillUpdateRequest->validated());

        return redirect(referer('admin.portfolio.skill.index'))
            ->with('success', $skill->name . ' updated successfully.');
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
