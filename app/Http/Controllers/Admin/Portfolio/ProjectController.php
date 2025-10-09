<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\StoreProjectRequest;
use App\Http\Requests\Portfolio\UpdateProjectRequest;
use App\Models\Portfolio\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ProjectController extends BaseController
{
    /**
     * Display a listing of projects.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $projects = Project::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.project.index', compact('projects'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new project.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.project.create');
    }

    /**
     * Store a newly created project in storage.
     *
     * @param StoreProjectRequest $storeProjectRequest
     * @return RedirectResponse
     */
    public function store(StoreProjectRequest $storeProjectRequest): RedirectResponse
    {
        $project = Project::create($storeProjectRequest->validated());

        return redirect(referer('admin.portfolio.project.index'))
            ->with('success', $project->name . ' project added successfully.');
    }

    /**
     * Display the specified project.
     *
     * @param Project $project
     * @return View
     */
    public function show(Project $project): View
    {
        return view('admin.portfolio.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param Project $project
     * @return View
     */
    public function edit(Project $project): View
    {
        return view('admin.portfolio.project.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param UpdateProjectRequest $updateProjectRequest
     * @param Project $project
     * @return RedirectResponse
     */
    public function update(UpdateProjectRequest $updateProjectRequest, Project $project): RedirectResponse
    {
        $project->update($updateProjectRequest->validated());

        return redirect(referer('admin.portfolio.project.index'))
            ->with('success', $project->name . ' project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     *
     * @param Project $project
     * @return RedirectResponse
     */
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect(referer('admin.portfolio.project.index'))
            ->with('success', $project->name . ' project deleted successfully.');
    }
}
