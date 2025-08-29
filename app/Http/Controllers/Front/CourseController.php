<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of the course.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $courses = Course::where('public', 1)
            ->where('disabled', 0)
            ->orderBy('sequence', 'asc')
            ->paginate($perPage);

        $title = 'Courses';
        return view('front.course.index', compact('courses', 'title'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course): View
    {
        return view('front.course.show', compact('course'));
    }
}
