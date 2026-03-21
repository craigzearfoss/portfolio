<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Course;
use App\Models\System\Admin;
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
        $perPage = $request->query('per_page', $this->perPage());

        $courses = new Course()->searchQuery(request()->except('id'), $this->owner ?? null)
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.portfolio.course.index'), compact('courses'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified course.
     *
     * @param Admin $admin
     * @param string $slug
     * @return View
     */
    public function show(Admin $admin, string $slug): View
    {
        if (!$course = new Course()->where('owner_id', '=', $admin['id'])
            ->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.course.show'), compact('course'));
    }
}
