<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreSchoolsRequest;
use App\Http\Requests\Portfolio\UpdateSchoolsRequest;
use App\Models\Portfolio\School;
use Exception;
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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'school', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $schools = School::searchQuery($request->all())
            ->where('name', '!=', 'other')
            ->orderBy('name')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

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
        createGate(PermissionEntityTypes::RESOURCE, 'school', $this->admin);

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
        createGate(PermissionEntityTypes::RESOURCE, 'school', $this->admin);

        $school = new School()->create($request->validated());

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
     * @param School $school
     * @return View
     */
    public function edit(School $school): View
    {
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
        $school->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $$school, $this->admin);

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
