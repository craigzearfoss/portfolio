<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\ApplicationStoreRequest;
use App\Http\Requests\Career\ApplicationUpdateRequest;
use App\Models\Career\Application;
use App\Models\Career\CoverLetter;
use App\Models\Career\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class ApplicationController extends BaseController
{
    /**
     * Display a listing of applications.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $applications = Application::latest()->paginate($perPage);

        return view('admin.career.application.index', compact('applications'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new application.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.application.create');
    }

    /**
     * Store a newly created application in storage.
     *
     * @param ApplicationStoreRequest $applicationStoreRequest
     * @return RedirectResponse
     */
    public function store(ApplicationStoreRequest $applicationStoreRequest): RedirectResponse
    {
        $application = Application::create($applicationStoreRequest->validated());

        // Create a cover letter for the application.
        CoverLetter::insert([
            'owner_id'       => $application->owner_id,
            'application_id' => $application->id,
        ]);

        return redirect(referer('admin.career.application.index'))
            ->with('success', 'Application added successfully.');
    }

    /**
     * Display the specified application.
     *
     * @param Application $application
     * @return View
     */
    public function show(Application $application): View
    {
        return view('admin.career.application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified application.
     *
     * @param Application $application
     * @return View
     */
    public function edit(Application $application): View
    {
        return view('admin.career.application.edit', compact('application'));
    }

    /**
     * Update the specified application in storage.
     *
     * @param ApplicationUpdateRequest $applicationUpdateRequest
     * @param Application $application
     * @return RedirectResponse
     */
    public function update(ApplicationUpdateRequest $applicationUpdateRequest,
                           Application $application): RedirectResponse
    {
        $application->update($applicationUpdateRequest->validated());

        return redirect(referer('admin.career.application.index'))
            ->with('success', 'Application updated successfully.');
    }

    /**
     * Remove the specified application from storage.
     *
     * @param Application $application
     * @return RedirectResponse
     */
    public function destroy(Application $application): RedirectResponse
    {
        $application->delete();

        return redirect(referer('admin.dictionary.database.index'))
            ->with('success', 'Application deleted successfully.');
    }

    public function showCoverLetter(Application $application): View
    {
        return view('admin.career.application.cover-letter.show', compact('application'));
    }
}
