<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoverLetterStoreRequest;
use App\Http\Requests\CoverLetterUpdateRequest;
use App\Models\Career\CoverLetter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoverLetterController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the cover letter.
     */
    public function index(): View
    {
        $coverLetters = CoverLetter::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.cover-letter.index', compact('coverLetters'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new cover letter.
     */
    public function create(): View
    {
        return view('admin.cover-letter.create');
    }

    /**
     * Store a newly created cover letter in storage.
     */
    public function store(CoverLetterStoreRequest $request): RedirectResponse
    {
        CoverLetter::create($request->validated());

        return redirect()->route('admin.cover-letter.index')
            ->with('success', 'Cover letter created successfully.');
    }

    /**
     * Display the specified cover letter.
     */
    public function show(CoverLetter $coverLetter): View
    {
        return view('admin.cover-letter.show', compact('coverLetter'));
    }

    /**
     * Show the form for editing the specified cover letter.
     */
    public function edit(CoverLetter $coverLetter)
    {
        return view('admin.cover-letter.edit', compact('coverLetter'));
    }

    /**
     * Update the specified cover letter in storage.
     */
    public function update(CoverLetterUpdateRequest $request, CoverLetter $coverLetter): RedirectResponse
    {
        $coverLetter->update($request->validated());

        return redirect()->route('admin.cover-letter.index')
            ->with('success', 'Cover letter updated successfully');
    }

    /**
     * Remove the specified cover letter from storage.
     */
    public function destroy(CoverLetter $coverLetter): RedirectResponse
    {
        $coverLetter->delete();

        return redirect()->route('user.link.index')
            ->with('success', 'Cover letter deleted successfully');
    }
}
