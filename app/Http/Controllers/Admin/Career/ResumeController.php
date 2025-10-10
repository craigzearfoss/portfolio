<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreResumeRequest;
use App\Http\Requests\Career\UpdateResumeRequest;
use App\Models\Career\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ResumeController extends BaseAdminController
{
    /**
     * Display a listing of resumes.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $resumes = Resume::orderBy('date', 'desc')
            ->orderby('name', 'asc')->paginate($perPage);

        return view('admin.career.resume.index', compact('resumes'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resume.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.resume.create');
    }

    /**
     * Store a newly created resume in storage.
     *
     * @param StoreResumeRequest $storeResumeRequest
     * @return RedirectResponse
     */
    public function store(StoreResumeRequest $storeResumeRequest): RedirectResponse
    {
        $resume = Resume::create($storeResumeRequest->validated());

        return redirect(referer('admin.career.resume.index'))
            ->with('success', $resume->name . ' resume added successfully.');
    }

    /**
     * Display the specified resume.
     *
     * @param Resume $resume
     * @return View
     */
    public function show(Resume $resume): View
    {
        return view('admin.career.resume.show', compact('resume'));
    }

    /**
     * Show the form for editing the specified resume.
     *
     * @param Resume $resume
     * @return View
     */
    public function edit(Resume $resume): View
    {
        return view('admin.career.resume.edit', compact('resume'));
    }

    /**
     * Update the specified resume in storage.
     *
     * @param UpdateResumeRequest $updateResumeRequest
     * @param Resume $resume
     * @return RedirectResponse
     */
    public function update(UpdateResumeRequest $updateResumeRequest, Resume $resume): RedirectResponse
    {
        $resume->update($updateResumeRequest->validated());

        return redirect(referer('admin.career.resume.index'))
            ->with('success', $resume->name . ' resume updated successfully.');
    }

    /**
     * Remove the specified resume from storage.
     *
     * @param Resume $resume
     * @return RedirectResponse
     */
    public function destroy(Resume $resume): RedirectResponse
    {
        $resume->delete();

        return redirect(referer('admin.career.resume.index'))
            ->with('success', $resume->name . ' resume deleted successfully.');
    }
}
