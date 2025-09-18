<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\CoverLetterStoreRequest;
use App\Http\Requests\Career\CoverLetterUpdateRequest;
use App\Models\Career\CoverLetter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class CoverLetterController extends BaseController
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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.cover-letter.create', compact('referer'));
    }

    /**
     * Store a newly created cover letter in storage.
     *
     * @param CoverLetterStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CoverLetterStoreRequest $request): RedirectResponse
    {
        $coverLetter = CoverLetter::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Cover Letter created successfully.');
        } else {
            return redirect()->route('admin.career.cover-letter.index')
                ->with('success', 'Cover letter created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(CoverLetter $coverLetter): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.cover-letter.edit', compact('coverLetter', 'referer'));
    }

    /**
     * Update the specified cover letter in storage.
     *
     * @param CoverLetterUpdateRequest $request
     * @param CoverLetter $coverLetter
     * @return RedirectResponse
     */
    public function update(CoverLetterUpdateRequest $request, CoverLetter $coverLetter): RedirectResponse
    {
        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('career_db.cover_letters', 'slug') ] ]);
        $coverLetter->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Cover letter updated successfully.');
        } else {
            return redirect()->route('admin.career.cover-letter.index')
                ->with('success', 'Cover letter updated successfully.');
        }
    }

    /**
     * Remove the specified cover letter from storage.
     *
     * @param CoverLetter $coverLetter
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(CoverLetter $coverLetter, Request $request): RedirectResponse
    {
        $coverLetter->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', 'Cover letter deleted successfully.');
        } else {
            return redirect()->route('admin.colver_letter.index')
                ->with('success', 'Cover letter deleted successfully.');
        }
    }
}
