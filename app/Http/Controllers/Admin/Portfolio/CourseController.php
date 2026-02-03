<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreCoursesRequest;
use App\Http\Requests\Portfolio\UpdateCoursesRequest;
use App\Models\Portfolio\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class CourseController extends BaseAdminController
{
    /**
     * Display a listing of coursest.
     *
     * @param Request $request
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $courses = Course::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $courses = Course::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Courses' : $this->owner->name . ' Courses';

        return view('admin.portfolio.course.index', compact('courses', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new course.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.course.create');
    }

    /**
     * Store a newly created course in storage.
     *
     * @param StoreCoursesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCoursesRequest $request): RedirectResponse
    {
        $course = Course::create($request->validated());

        return redirect()->route('admin.portfolio.course.show', $course)
            ->with('success', $course-> name . ' successfully added.');
    }

    /**
     * Display the specified course.
     *
     * @param Course $course
     * @return View
     */
    public function show(Course $course): View
    {
        list($prev, $next) = Course::prevAndNextPages($course->id,
            'admin.portfolio.course.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.course.show', compact('course', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified course.
     *
     * @param Course $course
     * @return View
     */
    public function edit(Course $course): View
    {
        Gate::authorize('update-resource', $course);

        return view('admin.portfolio.course.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     *
     * @param UpdateCoursesRequest $request
     * @param Course $course
     * @return RedirectResponse
     */
    public function update(UpdateCoursesRequest $request, Course $course): RedirectResponse
    {
        Gate::authorize('update-resource', $course);

        $course->update($request->validated());

        return redirect()->route('admin.portfolio.course.show', $course)
            ->with('success', $course->name . ' successfully updated.');
    }

    /**
     * Remove the specified course from storage.
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public function destroy(Course $course): RedirectResponse
    {
        Gate::authorize('delete-resource', $course);

        $course->delete();

        return redirect(referer('admin.portfolio.course.index'))
            ->with('success', $course->name . ' deleted successfully.');
    }
}
