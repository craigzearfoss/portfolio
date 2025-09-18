<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\SkillStoreRequest;
use App\Http\Requests\Career\SkillUpdateRequest;
use App\Models\Career\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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

        $skills = Skill::latest()->paginate($perPage);

        return view('admin.career.skill.index', compact('skills'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new skill.
     *
     * @return View
     */
    public function create(Request $request): View
    {
        return view('admin.career.skill.create');
    }

    /**
     * Store a newly created skill in storage.
     *
     * @param SkillStoreRequest $request
     * @return RedirectResponse
     */
    public function store(SkillStoreRequest $request): RedirectResponse
    {
        $skill = Skill::create($request->validated());

        return redirect(referer('admin.career.skill.index'))
            ->with('success', $skill->name . ' created successfully.');
    }

    /**
     * Display the specified skill.
     *
     * @param Skill $skill
     * @return View
     */
    public function show(Skill $skill): View
    {
        return view('admin.career.skill.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified skill.
     *
     * @param Skill $skill
     * @return View
     */
    public function edit(Skill $skill): View
    {
        return view('admin.career.skill.edit', compact('skill'));
    }

    /**
     * Update the specified skill in storage.
     *
     * @param SkillUpdateRequest $request
     * @param Skill $application
     * @return RedirectResponse
     */
    public function update(SkillUpdateRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validated());

        return redirect(referer('admin.career.skill.index'))
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

        return redirect(referer('admin.career.skill.index'))
            ->with('success', $skill->name . ' deleted successfully.');
    }
}
