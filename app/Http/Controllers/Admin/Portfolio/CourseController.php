<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Exports\Portfolio\CoursesExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreCoursesRequest;
use App\Http\Requests\Portfolio\UpdateCoursesRequest;
use App\Models\Portfolio\Course;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate( Course::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $courses = new Course()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Course::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Courses';

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
        createGate(Course::class, $this->admin);

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
        createGate(Course::class, $this->admin);

        $course = Course::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $course['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.portfolio.course.show', $course)
                ->with('success', $course['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified course.
     *
     * @param Course $course
     * @return View
     */
    public function show(Course $course): View
    {
        readGate($course, $this->admin);

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
        updateGate($course, $this->admin);

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

        updateGate($course, $this->admin);

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $course['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.course.show', $course)
                ->with('success', $course['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified course from storage.
     *
     * @param Course $course
     * @return RedirectResponse
     */
    public function destroy(Course $course): RedirectResponse
    {
        deleteGate($course, $this->admin);

        $course->delete();

        return redirect(referer('admin.portfolio.course.index'))
            ->with('success', $course['name'] . ' deleted successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $filename = request()->has('timestamp')
            ? 'courses_' . date("Y-m-d-His") . '.xlsx'
            : 'courses.xlsx';

        return Excel::download(new CoursesExport(), $filename);
    }
}
