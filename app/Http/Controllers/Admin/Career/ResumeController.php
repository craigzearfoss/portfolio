<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\ResumeStoreRequest;
use App\Http\Requests\Career\ResumeUpdateRequest;
use App\Models\Career\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResumeController extends BaseController
{
    /**
     * Display a listing of resumes.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $resumes = Resume::latest()->paginate($perPage);

        return view('admin.career.resume.index', compact('resumes'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resume.
     */
    public function create(): View
    {
        return view('admin.career.resume.create');
    }

    /**
     * Store a newly created resume in storage.
     */
    public function store(ResumeStoreRequest $request): RedirectResponse
    {
        Resume::create($request->validated());

        return redirect()->route('admin.career.resume.index')
            ->with('success', 'Resume created successfully.');
    }

    /**
     * Display the specified resume.
     */
    public function show(Resume $resume): View
    {
        return view('admin.career.resume.show', compact('resume'));
    }

    /**
     * Show the form for editing the specified resume.
     */
    public function edit(Resume $resume): View
    {
        return view('admin.career.resume.edit', compact('resume'));
    }

    /**
     * Update the specified resume in storage.
     */
    public function update(ResumeUpdateRequest $request, Resume $resume): RedirectResponse
    {
        $resume->update($request->validated());

        return redirect()->route('admin.career.resume.index')
            ->with('success', 'Resume updated successfully');
    }

    /**
     * Remove the specified resume from storage.
     */
    public function destroy(Resume $resume): RedirectResponse
    {
        $resume->delete();

        return redirect()->route('admin.career.resume.index')
            ->with('success', 'Resume deleted successfully');
    }
}
