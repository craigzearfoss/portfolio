<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerSkillStoreRequest;
use App\Http\Requests\CareerSkillUpdateRequest;
use App\Models\Career\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of skills.
     */
    public function index(): View
    {
        $skills = Skill::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.skill.index', compact('skills'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new skill.
     */
    public function create(): View
    {
        return view('admin.skill.create');
    }

    /**
     * Store a newly created skill in storage.
     */
    public function store(CareerSkillStoreRequest $request): RedirectResponse
    {
        Skill::create($request->validated());

        return redirect()->route('admin.skill.index')
            ->with('success', 'Skill created successfully.');
    }

    /**
     * Display the specified skill.
     */
    public function show(Skill $skill): View
    {
        return view('admin.skill.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified skill.
     */
    public function edit(Skill $skill): View
    {
        return view('admin.skill.edit', compact('skill'));
    }

    /**
     * Update the specified skill in storage.
     */
    public function update(CareerSkillUpdateRequest $request, Skill $skill): RedirectResponse
    {
        dd($request);

        $skill->update($request->validated());

        return redirect()->route('admin.skill.index')
            ->with('success', 'Skill updated successfully');
    }

    /**
     * Remove the specified skill from storage.
     */
    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skill.index')
            ->with('success', 'Skill deleted successfully');
    }
}
