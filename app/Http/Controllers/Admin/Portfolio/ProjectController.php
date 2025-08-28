<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioProjectStoreRequest;
use App\Http\Requests\PortfolioProjectUpdateRequest;
use App\Models\Portfolio\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of projects.
     */
    public function index(): View
    {
        $projects = Project::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.project.index', compact('projects'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        return view('admin.project.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(PortfolioProjectStoreRequest $request): RedirectResponse
    {
        Project::create($request->validated());

        return redirect()->route('admin.project.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        return view('admin.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        return view('admin.project.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(PortfolioProjectUpdateRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        return redirect()->route('admin.project.index')
            ->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.project.index')
            ->with('success', 'Project deleted successfully');
    }
}
