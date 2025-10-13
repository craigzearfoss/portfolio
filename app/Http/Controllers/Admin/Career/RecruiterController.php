<?php

namespace App\Http\Controllers\Admin\Career;

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
        $perPage = $request->query('per_page', $this->perPage);

        $recruiters = Recruiter::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.career.recruiter.index', compact('recruiters'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new recruiter.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.recruiter.create');
    }

    /**
     * Store a newly created recruiter in storage.
     *
     * @param StoreRecruitersRequest $storeRecruitersRequest
     * @return RedirectResponse
     */
    public function store(StoreRecruitersRequest $storeRecruitersRequest): RedirectResponse
    {
        $recruiter = Recruiter::create($storeRecruitersRequest->validated());

        return redirect(referer('admin.career.recruiter.index'))
            ->with('success', $recruiter->name . ' added successfully.');
    }

    /**
     * Display the specified recruiter.
     *
     * @param Recruiter $recruiter
     * @return View
     */
    public function show(Recruiter $recruiter): View
    {
        return view('admin.career.recruiter.show', compact('recruiter'));
    }

    /**
     * Show the form for editing the specified recruiter.
     *
     * @param Recruiter $recruiter
     * @return View
     */
    public function edit(Recruiter $recruiter): View
    {
        return view('admin.career.recruiter.edit', compact('recruiter'));
    }

    /**
     * Update the specified recruiter in storage.
     *
     * @param UpdateRecruitersRequest $updateRecruitersRequest
     * @param Recruiter $recruiter
     * @return RedirectResponse
     */
    public function update(UpdateRecruitersRequest $updateRecruitersRequest, Recruiter $recruiter): RedirectResponse
    {
        $recruiter->update($updateRecruitersRequest->validated());

        return redirect(referer('admin.career.recruiter.index'))
            ->with('success', $recruiter->name . ' updated successfully.');
    }

    /**
     * Remove the specified recruiter from storage.
     *
     * @param Recruiter $recruiter
     * @return RedirectResponse
     */
    public function destroy(Recruiter $recruiter): RedirectResponse
    {
        $recruiter->delete();

        return redirect(referer('admin.career.recruiter.index'))
            ->with('success', $recruiter->name . ' deleted successfully.');
    }
}
