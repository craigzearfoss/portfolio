<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\CareerResumeStoreRequest;
use App\Http\Requests\Career\CareerResumeUpdateRequest;
use App\Models\Career\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResumeController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of resumes.
     */
    public function index(): View
    {
        $resumes = Resume::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.career.resume.index', compact('resumes'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
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
    public function store(CareerResumeStoreRequest $request): RedirectResponse
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
    public function update(CareerResumeUpdateRequest $request, Resume $resume): RedirectResponse
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
