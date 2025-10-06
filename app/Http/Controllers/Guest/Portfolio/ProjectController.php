<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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

        $projects = Project::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($perPage);

        $title = 'Projects';
        return view('guest.portfolio.project.index', compact('projects', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified project.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$project = Project::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('guest.portfolio.project.show', compact('project'));
    }
}
