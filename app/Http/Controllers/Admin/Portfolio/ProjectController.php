<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\ProjectStoreRequest;
use App\Http\Requests\Portfolio\ProjectUpdateRequest;
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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.project.create', compact('referer'));
    }

    /**
     * Store a newly created project in storage.
     *
     * @param ProjectStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ProjectStoreRequest $request): RedirectResponse
    {
        $project = Project::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $project->name . ' created successfully.');
        } else {
            return redirect()->route('admin.portfolio.link.index')
                ->with('success', $project->name . ' created successfully.');
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
        return view('admin.portfolio.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param Project $project
     * @param Request $request
     * @return View
     */
    public function edit(Project $project): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.project.edit', compact('project', 'referer'));
    }

    /**
     * Update the specified project in storage.
     *
     * @param ProjectUpdateRequest $request
     * @param Project $project
     * @return RedirectResponse
     */
    public function update(ProjectUpdateRequest $request, Project $project): RedirectResponse
    {
        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('portfolio_db.projects', 'slug') ] ]);
        $project->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $project->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.link.index')
                ->with('success', $project->name . ' updated successfully.');
        }
    }

    /**
     * Remove the specified project from storage.
     *
     * @param Project $project
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Project $project, Request $request): RedirectResponse
    {
        $project->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $project->name . ' link deleted successfully.');
        } else {
            return redirect()->route('admin.portfolio.link.index')
                ->with('success', $project->name . ' link deleted successfully.');
        }
    }
}
