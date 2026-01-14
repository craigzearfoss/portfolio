<?php

namespace App\Http\Controllers\Admin\Root\Career;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Http\Requests\Career\StoreRecruitersRequest;
use App\Http\Requests\Career\UpdateRecruitersRequest;
use App\Models\Career\Recruiter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class RecruiterController extends BaseAdminRootController
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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add recruiters.');
        }

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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add recruiters.');
        }

        $recruiter = Recruiter::create($request->validated());

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
        Gate::authorize('update-resource', $recruiter);

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
        Gate::authorize('update-resource', $recruiter);

        $recruiter->update($request->validated());

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
        Gate::authorize('delete-resource', $recruiter);

        $recruiter->delete();

        return redirect(referer('admin.career.recruiter.index'))
            ->with('success', $recruiter->name . ' deleted successfully.');
    }
}
