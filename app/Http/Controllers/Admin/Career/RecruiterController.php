<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\RecruiterStoreRequest;
use App\Http\Requests\Career\RecruiterUpdateRequest;
use App\Models\Career\Recruiter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecruiterController extends Controller
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
     * @param RecruiterStoreRequest $request
     * @return RedirectResponse
     */
    public function store(RecruiterStoreRequest $request): RedirectResponse
    {
        $recruiter = Recruiter::create($request->validated());

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
     * @param RecruiterUpdateRequest $request
     * @param Recruiter $recruiter
     * @return RedirectResponse
     */
    public function update(RecruiterUpdateRequest $request, Recruiter $recruiter): RedirectResponse
    {
        $recruiter->update($request->validated());

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
