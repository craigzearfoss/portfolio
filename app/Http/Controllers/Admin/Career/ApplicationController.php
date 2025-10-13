<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreApplicationsRequest;
use App\Http\Requests\Career\UpdateApplicationsRequest;
use App\Models\Career\Application;
use App\Models\Career\CoverLetter;
use App\Models\Career\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class ApplicationController extends BaseAdminController
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
     * @param StoreApplicationsRequest $storeApplicationsStoreRequest
     * @return RedirectResponse
     */
    public function store(StoreApplicationsRequest $storeApplicationsStoreRequest): RedirectResponse
    {
        $application = Application::create($storeApplicationsStoreRequest->validated());

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
        if (empty($application->coverLetter)) {
            $application = $this->createCoverLetter($application);
        }

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
     * @param UpdateApplicationsRequest $updateApplicationsRequest
     * @param Application $application
     * @return RedirectResponse
     */
    public function update(UpdateApplicationsRequest $updateApplicationsRequest,
                           Application               $application): RedirectResponse
    {
        $application->update($updateApplicationsRequest->validated());

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
        if (empty($application->coverLetter)) {
            $application = $this->createCoverLetter($application);
        }

        return view('admin.career.application.cover-letter.show', compact('application'));
    }

    /**
     * Show the form for editing the specified application.
     *
     * @param Application $application
     * @return View
     */
    public function editCoverLetter(Application $application): View
    {
        if (empty($application->coverLetter)) {
            $application = $this->createCoverLetter($application);
        }

        return view('admin.career.application.cover-letter.edit', compact('application'));
    }

    /**
     * Update the specified application in storage.
     *
     * @param UpdateApplicationsRequest $updateApplicationsRequest
     * @param Application $application
     * @return RedirectResponse
     */
    public function updateCoverLetter(UpdateApplicationsRequest $updateApplicationsRequest,
                                      Application               $application): RedirectResponse
    {
        $application->update($updateApplicationsRequest->validated());

        return redirect(referer('admin.career.application.index'))
            ->with('success', 'Application updated successfully.');
    }

    /**
     * Create a cover letter.
     *
     * @param Application $application
     * @return Application
     */
    protected function createCoverLetter(Application $application): Application
    {
        if (empty($application->coverLetter)) {
            CoverLetter::insert([
                'owner_id'       => $application->owner_id,
                'application_id' => $application->id,
            ]);
            $application = Application::find($application->id);
        }

        return $application;
    }
}
