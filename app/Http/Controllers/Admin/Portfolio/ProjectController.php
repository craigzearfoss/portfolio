<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Exports\Portfolio\ProjectsExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreProjectsRequest;
use App\Http\Requests\Portfolio\UpdateProjectsRequest;
use App\Models\Portfolio\Project;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Project::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $projects = new Project()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Project::SEARCH_ORDER_BY),
            !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Projects';

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
        createGate(Project::class, $this->admin);

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
        createGate(Project::class, $this->admin);

        $project = Project::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $project['name'] . ' project successfully added.');
        } else {
            return redirect()->route('admin.portfolio.project.show', $project)
                ->with('success', $project->name . ' project successfully added.');
        }
    }

    /**
     * Display the specified project.
     *
     * @param Project $project
     * @return View
     */
    public function show(Project $project): View
    {
        readGate($project, $this->admin);

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
        updateGate($project, $this->admin);

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

        updateGate($project, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $project['name'] . ' project successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.project.show', $project)
                ->with('success', $project->name . ' project successfully updated.');
        }
    }

    /**
     * Remove the specified project from storage.
     *
     * @param Project $project
     * @return RedirectResponse
     */
    public function destroy(Project $project): RedirectResponse
    {
        deleteGate($project, $this->admin);

        $project->delete();

        return redirect(referer('admin.portfolio.project.index'))
            ->with('success', $project->name . ' project deleted successfully.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(Project::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'projects_' . date("Y-m-d-His") . '.xlsx'
            : 'projects.xlsx';

        return Excel::download(new ProjectsExport(), $filename);
    }
}
