<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreCoursesRequest;
use App\Http\Requests\Portfolio\UpdateCoursesRequest;
use App\Models\Portfolio\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'course', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $courses = new Course()->searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootAdmin() && !empty($owner_id)) ? $this->owner->name . ' Courses' : 'Courses';

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
        createGate(PermissionEntityTypes::RESOURCE, 'course', $this->admin);

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
        createGate(PermissionEntityTypes::RESOURCE, 'course', $this->admin);

        $course = new Course()->create($request->validated());

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
        readGate(PermissionEntityTypes::RESOURCE, $course, $this->admin);

        list($prev, $next) = $course->prevAndNextPages(
            $course['id'],
            'admin.portfolio.course.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

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
        updateGate(PermissionEntityTypes::RESOURCE, $course, $this->admin);

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
        $course->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $course, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $course, $this->admin);

        $course->delete();

        return redirect(referer('admin.portfolio.course.index'))
            ->with('success', $course->name . ' deleted successfully.');
    }
}
