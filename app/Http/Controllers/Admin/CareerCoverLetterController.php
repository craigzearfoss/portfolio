<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerCoverLetterStoreRequest;
use App\Http\Requests\CareerCoverLetterUpdateRequest;
use App\Models\Career\CoverLetter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CareerCoverLetterController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of cover letters.
     */
    public function index(): View
    {
        $coverLetters = CoverLetter::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.cover_letter.index', compact('coverLetters'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new cover letter.
     */
    public function create(): View
    {
        return view('admin.cover_letter.create');
    }

    /**
     * Store a newly created cover letter in storage.
     */
    public function store(CareerCoverLetterStoreRequest $request): RedirectResponse
    {
        CoverLetter::create($request->validated());

        return redirect()->route('admin.cover_letter.index')
            ->with('success', 'Cover letter created successfully.');
    }

    /**
     * Display the specified cover letter.
     */
    public function show(CoverLetter $coverLetter): View
    {
        return view('admin.cover_letter.show', compact('coverLetter'));
    }

    /**
     * Show the form for editing the specified cover letter.
     */
    public function edit(CoverLetter $coverLetter): View
    {
        return view('admin.cover_letter.edit', compact('coverLetter'));
    }

    /**
     * Update the specified cover letter in storage.
     */
    public function update(CareerCoverLetterUpdateRequest $request, CoverLetter $coverLetter): RedirectResponse
    {
        $coverLetter->update($request->validated());

        return redirect()->route('admin.cover_letter.index')
            ->with('success', 'Cover letter updated successfully');
    }

    /**
     * Remove the specified cover letter from storage.
     */
    public function destroy(CoverLetter $coverLetter): RedirectResponse
    {
        $coverLetter->delete();

        return redirect()->route('admin.colver_letter.index')
            ->with('success', 'Cover letter deleted successfully');
    }
}
