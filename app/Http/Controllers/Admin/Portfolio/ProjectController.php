<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreProjectsRequest;
use App\Http\Requests\Portfolio\UpdateProjectsRequest;
use App\Models\Portfolio\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        readGate(PermissionEntityTypes::RESOURCE, 'project', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $projects = new Project()->searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootAdmin() && !empty($owner_id)) ? $this->owner->name . ' Projects' : 'Projects';

        return view('admin.portfolio.project.index', compact('projects', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new project.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'project', $this->admin);

        return view('admin.portfolio.project.create');
    }

    /**
     * Store a newly created project in storage.
     *
     * @param StoreProjectsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProjectsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'project', $this->admin);

        $project = new Project()->create($request->validated());

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
        readGate(PermissionEntityTypes::RESOURCE, $project, $this->admin);

        list($prev, $next) = $project->prevAndNextPages(
            $project['id'],
            'admin.portfolio.project.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.project.show', compact('project', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param Project $project
     * @return View
     */
    public function edit(Project $project): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $project, $this->admin);

        return view('admin.portfolio.project.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param UpdateProjectsRequest $request
     * @param Project $project
     * @return RedirectResponse
     */
    public function update(UpdateProjectsRequest $request, Project $project): RedirectResponse
    {
        $project->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $project, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $project, $this->admin);

        $project->delete();

        return redirect(referer('admin.portfolio.project.index'))
            ->with('success', $project->name . ' project deleted successfully.');
    }
}
