<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the project.
     */
    public function index(): View
    {
        $projects = Project::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate(self::NUM_PER_PAGE);

        $title = 'Projects';
        return view('front.project.index', compact('projects', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }
}
