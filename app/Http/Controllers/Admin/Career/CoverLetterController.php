<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\UpdateApplicationsRequest;
use App\Http\Requests\Career\StoreCoverLettersRequest;
use App\Http\Requests\Career\UpdateCoverLettersRequest;
use App\Models\Career\CoverLetter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class CoverLetterController extends BaseAdminController
{
    /**
     * Display a listing of cover letters.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $coverLetters = CoverLetter::latest()->paginate($perPage);

        return view('admin.career.cover-letter.index', compact('coverLetters'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new cover letter.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.cover-letter.create');
    }

    /**
     * Store a newly created cover letter in storage.
     *
     * @param StoreCoverLettersRequest $storeCoverLettersRequest
     * @return RedirectResponse
     */
    public function store(StoreCoverLettersRequest $storeCoverLettersRequest): RedirectResponse
    {
        $coverLetter = CoverLetter::create($storeCoverLettersRequest->validated());

        return redirect(referer('admin.career.cover-letter.index'))
            ->with('success', 'Cover Letter added successfully.');
    }

    /**
     * Display the specified cover letter.
     *
     * @param CoverLetter $coverLetter
     * @return View
     */
    public function show(CoverLetter $coverLetter): View
    {
        return view('admin.career.cover-letter.show', compact('coverLetter'));
    }

    /**
     * Show the form for editing the specified cover letter.
     *
     * @param CoverLetter $coverLetter
     * @return View
     */
    public function edit(CoverLetter $coverLetter): View
    {
        return view('admin.career.cover-letter.edit', compact('coverLetter'));
    }

    /**
     * Update the specified cover letter in storage.
     *
     * @param UpdateApplicationsRequest $updateApplicationsRequest
     * @param CoverLetter $coverLetter
     * @return RedirectResponse
     */
    public function update(UpdateApplicationsRequest $updateApplicationsRequest,
                           CoverLetter               $coverLetter): RedirectResponse
    {
        $coverLetter->update($updateApplicationsRequest->validated());

        return redirect(referer('admin.career.cover-letter.index'))
            ->with('success', 'Cover letter updated successfully.');
    }

    /**
     * Remove the specified cover letter from storage.
     *
     * @param CoverLetter $coverLetter
     * @return RedirectResponse
     */
    public function destroy(CoverLetter $coverLetter): RedirectResponse
    {
        $coverLetter->delete();

        return redirect(referer('admin.career.cover-letter.index'))
            ->with('success', 'Cover letter deleted successfully.');
    }
}
