<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    protected $numPerPage = 20;

    /**
     * Display a listing of the project.
     */
    public function index(): View
    {
        $projects = Project::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($this->numPerPage);

        $title = 'Projects';
        return view('front.project.index', compact('projects', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $this->numPerPage);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        return view('front.project.show', compact('project'));
    }
}
