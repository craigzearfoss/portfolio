<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Portfolio\Course;
use App\Models\System\Admin;
use Exception;
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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $courses = new Course()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Course::SEARCH_ORDER_BY),
            $this->owner ?? null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Courses';

        return view(themedTemplate('guest.portfolio.course.index'), compact('courses', 'pageTitle'))
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
        if (!$course = Course::query()->where('owner_id', '=', $admin['id'])
            ->where('slug', '=', $slug)->first()
        ) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.portfolio.course.show'), compact('course'));
    }
}
