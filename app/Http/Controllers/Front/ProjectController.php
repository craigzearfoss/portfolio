<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of the project.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $projects = Project::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($perPage);

        $title = 'Projects';
        return view('front.project.index', compact('projects', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        return view('front.project.show', compact('project'));
    }
}
