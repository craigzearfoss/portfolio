<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\BaseController;
use App\Models\Portfolio\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class CourseController extends BaseController
{
    /**
     * Display a listing of courses.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $courses = Course::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        $title = 'Courses';

        return view('guest.portfolio.course.index', compact('courses', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified course.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$course = Course::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('guest.portfolio.course.show', compact('course'));
    }
}
