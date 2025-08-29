<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\SkillStoreRequest;
use App\Http\Requests\Career\SkillUpdateRequest;
use App\Models\Career\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SkillController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of skills.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $skills = Skill::latest()->paginate($perPage);

        return view('admin.career.skill.index', compact('skills'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new skill.
     */
    public function create(): View
    {
        return view('admin.career.skill.create');
    }

    /**
     * Store a newly created skill in storage.
     */
    public function store(SkillStoreRequest $request): RedirectResponse
    {
        Skill::create($request->validated());

        return redirect()->route('admin.career.skill.index')
            ->with('success', 'Skill created successfully.');
    }

    /**
     * Display the specified skill.
     */
    public function show(Skill $skill): View
    {
        return view('admin.career.skill.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified skill.
     */
    public function edit(Skill $skill): View
    {
        return view('admin.career.skill.edit', compact('skill'));
    }

    /**
     * Update the specified skill in storage.
     */
    public function update(SkillUpdateRequest $request, Skill $skill): RedirectResponse
    {
        dd($request);

        $skill->update($request->validated());

        return redirect()->route('admin.career.skill.index')
            ->with('success', 'Skill updated successfully');
    }

    /**
     * Remove the specified skill from storage.
     */
    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.career.skill.index')
            ->with('success', 'Skill deleted successfully');
    }
}
