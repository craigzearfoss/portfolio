<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\ResumeStoreRequest;
use App\Http\Requests\Career\ResumeUpdateRequest;
use App\Models\Career\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
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
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.resume.create', compact('referer'));
    }

    /**
     * Store a newly created resume in storage.
     *
     * @param ResumeStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ResumeStoreRequest $request): RedirectResponse
    {
        $resume = Resume::create($request->validated());

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $resume->name . ' resume created successfully.');
        } else {
            return redirect()->route('admin.career.resume.index')
                ->with('success', $resume->name . ' resume created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(Resume $resume, Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.career.resume.edit', compact('resume', 'referer'));
    }

    /**
     * Update the specified resume in storage.
     *
     * @param ResumeUpdateRequest $request
     * @param Resume $resume
     * @return RedirectResponse
     */
    public function update(ResumeUpdateRequest $request, Resume $resume): RedirectResponse
    {
        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('career_db.resumes', 'slug') ] ]);
        $resume->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $resume->name . ' resume updated successfully.');
        } else {
            return redirect()->route('admin.career.resume.index')
                ->with('success', $resume->name . ' resume updated successfully');
        }
    }

    /**
     * Remove the specified resume from storage.
     *
     * @param Resume $resume
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Resume $resume, Request $request): RedirectResponse
    {
        $resume->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $resume->name . ' resume deleted successfully.');
        } else {
            return redirect()->route('admin.career.resume.index')
                ->with('success', $resume->name . ' resume deleted successfully');
        }
    }
}
