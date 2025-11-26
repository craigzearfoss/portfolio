<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreProjectsRequest;
use App\Http\Requests\Portfolio\UpdateProjectsRequest;
use App\Models\Portfolio\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ProjectController extends BaseAdminController
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
     * @param StoreProjectsRequest $storeProjectsRequest
     * @return RedirectResponse
     */
    public function store(StoreProjectsRequest $storeProjectsRequest): RedirectResponse
    {
        $project = Project::create($storeProjectsRequest->validated());

        return redirect()->route('admin.portfolio.project.show', $project)
            ->with('success', $project->name . ' project successfully added.');
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
     * @param UpdateProjectsRequest $updateProjectsRequest
     * @param Project $project
     * @return RedirectResponse
     */
    public function update(UpdateProjectsRequest $updateProjectsRequest, Project $project): RedirectResponse
    {
        $project->update($updateProjectsRequest->validated());

        return redirect()->route('admin.portfolio.project.show', $project)
            ->with('success', $project->name . ' project successfully updated.');
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
