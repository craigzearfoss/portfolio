<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioCourseStoreRequest;
use App\Http\Requests\PortfolioCourseUpdateRequest;
use App\Models\Portfolio\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PortfolioCourseController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the course.
     */
    public function index(): View
    {
        $courses = Course::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.course.index', compact('courses'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new course.
     */
    public function create(): View
    {
        return view('admin.course.create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(PortfolioCourseStoreRequest $request): RedirectResponse
    {
        Course::create($request->validated());

        return redirect()->route('admin.course.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course): View
    {
        return view('admin.course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course): View
    {
        return view('admin.course.edit', compact('course'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(PortfolioCourseUpdateRequest $request, Course $course): RedirectResponse
    {
        dd($request);

        $course->update($request->validated());

        return redirect()->route('admin.course.index')
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('admin.course.index')
            ->with('success', 'Course deleted successfully');
    }
}
