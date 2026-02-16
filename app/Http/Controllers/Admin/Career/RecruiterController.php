<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreRecruitersRequest;
use App\Http\Requests\Career\UpdateRecruitersRequest;
use App\Models\Career\Recruiter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecruiterController extends BaseAdminController
{
    /**
     * Display a listing of recruiters.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'recruiter', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $recruiters = new Recruiter()->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Recruiters';

        return view('admin.career.recruiter.index', compact('recruiters', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recruiter.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'recruiter', $this->admin);

        return view('admin.career.recruiter.create');
    }

    /**
     * Store a newly created recruiter in storage.
     *
     * @param StoreRecruitersRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRecruitersRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'certificate', $this->admin);

        $recruiter = new Recruiter()->create($request->validated());

        return redirect()->route('admin.career.recruiter.show', $recruiter)
            ->with('success', $recruiter->name . ' successfully added.');
    }

    /**
     * Display the specified recruiter.
     *
     * @param Recruiter $recruiter
     * @return View
     */
    public function show(Recruiter $recruiter): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $recruiter, $this->admin);

        list($prev, $next) = Recruiter::prevAndNextPages($recruiter->id,
            'admin.career.recruiter.show',
            null,
            ['name', 'asc']);

        return view('admin.career.recruiter.show', compact('recruiter', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified recruiter.
     *
     * @param Recruiter $recruiter
     * @return View
     */
    public function edit(Recruiter $recruiter): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $recruiter, $this->admin);

        return view('admin.career.recruiter.edit', compact('recruiter'));
    }

    /**
     * Update the specified recruiter in storage.
     *
     * @param UpdateRecruitersRequest $request
     * @param Recruiter $recruiter
     * @return RedirectResponse
     */
    public function update(UpdateRecruitersRequest $request, Recruiter $recruiter): RedirectResponse
    {
        $recruiter->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $$recruiter, $this->admin);

        return redirect()->route('admin.career.recruiter.show', $recruiter)
            ->with('success', $recruiter->name . ' successfully updated.');
    }

    /**
     * Remove the specified recruiter from storage.
     *
     * @param Recruiter $recruiter
     * @return RedirectResponse
     */
    public function destroy(Recruiter $recruiter): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $recruiter, $this->admin);

        $recruiter->delete();

        return redirect(referer('admin.career.recruiter.index'))
            ->with('success', $recruiter->name . ' deleted successfully.');
    }
}
