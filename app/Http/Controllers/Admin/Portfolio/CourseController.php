<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\CourseStoreRequest;
use App\Http\Requests\Portfolio\CourseUpdateRequest;
use App\Models\Portfolio\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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

        $courses = Course::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.course.index', compact('courses'))
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
     * @param CourseStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CourseStoreRequest $request): RedirectResponse
    {
        $course = Course::create($request->validated());

        return redirect(referer('admin.portfolio.course.index'))
            ->with('success', $course-> name . ' added successfully.');
    }

    /**
     * Display the specified course.
     *
     * @param Course $course
     * @return View
     */
    public function show(Course $course): View
    {
        return view('admin.portfolio.course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     *
     * @param Course $course
     * @return View
     */
    public function edit(Course $course): View
    {
        return view('admin.portfolio.course.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     *
     * @param CourseUpdateRequest $request
     * @param Course $course
     * @return RedirectResponse
     */
    public function update(CourseUpdateRequest $request, Course $course): RedirectResponse
    {
        $course->update($request->validated());

        return redirect(referer('admin.portfolio.course.index'))
            ->with('success', $course->name . ' updated successfully.');
    }

    /**
     * Remove the specified course from storage.
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect(referer('admin.portfolio.course.index'))
            ->with('success', $course->name . ' deleted successfully.');
    }
}
