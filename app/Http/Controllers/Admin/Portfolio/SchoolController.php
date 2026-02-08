<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreSchoolsRequest;
use App\Http\Requests\Portfolio\UpdateSchoolsRequest;
use App\Models\Portfolio\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class SchoolController extends BaseAdminController
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
        readGate(PermissionEntityTypes::RESOURCE, 'school', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $schools = School::searchBuilder($request->all(), ['name', 'asc'])->paginate($perPage)
            ->appends(request()->except('page'));

        $pageTitle = 'Schools';

        return view('admin.portfolio.school.index', compact('schools', 'pageTitle'))
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
     * @param StoreSchoolsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreSchoolsRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add schools.');
        }

        $school = School::create($request->validated());

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
        readGate(PermissionEntityTypes::RESOURCE, $school, $this->admin);

        list($prev, $next) = School::prevAndNextPages($school->id,
            'admin.portfolio.school.show',
            null,
            ['name', 'asc']);

        return view('admin.portfolio.school.show', compact('school', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified school.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $school = School::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $school, $this->admin);

        return view('admin.portfolio.school.edit', compact('school'));
    }

    /**
     * Update the specified school in storage.
     *
     * @param UpdateSchoolsRequest $request
     * @param School $school
     * @return RedirectResponse
     */
    public function update(UpdateSchoolsRequest $request, School $school): RedirectResponse
    {
        Gate::authorize('update-resource', $school);

        $school->update($request->validated());

        return redirect()->route('admin.portfolio.school.show', $school)
            ->with('success', $school->name . ' successfully updated.');
    }

    /**
     * Remove the specified school from storage.
     *
     * @param School $school
     * @return RedirectResponse
     */
    public function destroy(School $school): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $school, $this->admin);

        $school->delete();

        return redirect(str_replace(config('app.url'), '', 'admin.portfolio.school.index'))
            ->with('success', $school->name . ' deleted successfully.');
    }
}
