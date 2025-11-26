<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StoreSchoolsRequest;
use App\Http\Requests\Portfolio\UpdateSchoolsRequest;
use App\Models\Portfolio\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class SchoolController extends Controller
{
    /**
     * Display a listing of schools.
     *
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        //$schools = School::orderBy('name', 'asc')->paginate($perPage);
        $schools = School::searchBuilder($request->all(), ['name', 'asc'])->paginate($perPage)
            ->appends(request()->except('page'));

        return view('admin.portfolio.school.index', compact('schools'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new school.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add schools.');
        }

        return view('admin.portfolio.school.create');
    }

    /**
     * Store a newly created school in storage.
     *
     * @param StoreSchoolsRequest $storeSchoolsRequest
     * @return RedirectResponse
     */
    public function store(StoreSchoolsRequest $storeSchoolsRequest): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add schools.');
        }

        $school = School::create($storeSchoolsRequest->validated());

        return redirect()->route('admin.portfolio.school.show', $school)
            ->with('success', $school->name . ' successfully added.');
    }

    /**
     * Display the specified school.
     *
     * @param School $school
     * @return View
     */
    public function show(School $school): View
    {
        return view('admin.portfolio.school.show', compact('school'));
    }

    /**
     * Show the form for editing the specified school.
     *
     * @param School $school
     * @return View
     */
    public function edit(School $school): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can edit schools.');
        }

        return view('admin.portfolio.school.edit', compact('school'));
    }

    /**
     * Update the specified school in storage.
     *
     * @param UpdateSchoolsRequest $updateSchoolsRequest
     * @param School $school
     * @return RedirectResponse
     */
    public function update(UpdateSchoolsRequest $updateSchoolsRequest, School $school): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update schools.');
        }

        $school->update($updateSchoolsRequest->validated());

        return redirect(referer('admin.portfolio.school.index'))
            ->with('success', $school->name . ' updated successfully.');
    }

    /**
     * Remove the specified school from storage.
     *
     * @param School $school
     * @return RedirectResponse
     */
    public function destroy(School $school): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete schools.');
        }

        $school->delete();

        return redirect(str_replace(config('app.url'), '', 'admin.portfolio.school.index'))
            ->with('success', $school->name . ' deleted successfully.');
    }
}
