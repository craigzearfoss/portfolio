<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class CourseController extends BaseGuestController
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

        return view(themedTemplate('guest.portfolio.course.index'), compact('courses'))
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

        return view(themedTemplate('guest.portfolio.course.show'), compact('course'));
    }
}
