<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreApplicationsRequest;
use App\Http\Requests\Career\UpdateApplicationsRequest;
use App\Models\Career\Application;
use App\Models\Career\Company;
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
        readGate(PermissionEntityTypes::RESOURCE, 'application', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $query = new Application()->searchQuery(request()->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('created_at', 'desc');
        if ($resume = $request->resume_id ? new Resume()->findOrFail($request->resume_id) : null) {
            $query->where('resume_id', $resume->id);
        }

        $applications = $query->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootAdmin() && !empty($owner_id)) ? $this->owner->name . ' Applications' : 'Applications';

        return view('admin.career.application.index', compact('applications', 'resume', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new application.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'application', $this->admin);

        $errorMessages = [];
        $urlParams = [];

        if ($companyId = $request->query('company_id')) {
            $urlParams['company_id'] = $companyId;
            if (!new Company()->find($companyId)) {
                $errorMessages[] = "Company `$companyId` not found.";
            }
        }

        if ($resumeId = $request->query('resume_id')) {
            $urlParams['resume_id'] = $resumeId;
            if (!new Resume()->find($resumeId)) {
                $errorMessages[] = "Resume `$resumeId` not found.";
            }
        }

        if ($coverLetterId = $request->query('cover_letter_id')) {
            $urlParams['cover_letter_id'] = $coverLetterId;
            if (!new CoverLetter()->find($coverLetterId)) {
                $errorMessages[] = "Cover letter `$coverLetterId` not found.";
            }
        }

        if (!empty($errorMessages)) {
            return view('admin.career.application.create', $urlParams)
                ->withErrors(['GLOBAL' => implode('<br>', $errorMessages)]);
        } else {
            return view(
                'admin.career.application.create',
                compact('companyId', 'resumeId', 'coverLetterId', 'urlParams')
            );
        }
    }

    /**
     * Store a newly created application in storage.
     *
     * @param StoreApplicationsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreApplicationsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'application', $this->admin);

        $application = new Application()->create($request->validated());

        // Create a cover letter for the application.
        new CoverLetter()->insert([
            'owner_id'       => $application->owner_id,
            'application_id' => $application->id,
        ]);

        return redirect()->route('admin.career.application.show', $application)
            ->with('success', 'Application successfully added.');
    }

    /**
     * Display the specified application.
     *
     * @param Application $application
     * @return View
     */
    public function show(Application $application): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $application, $this->admin);

        if (empty($application->coverLetter)) {
            $application = $this->createCoverLetter($application);
        }

        list($prev, $next) = $application->prevAndNextPages(
            $application['id'],
            'admin.career.application.show',
            $this->owner ?? null,
            [ 'post_date', 'asc' ]
        );

        return view('admin.career.application.show', compact('application', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified application.
     *
     * @param Application $application
     * @return View
     */
    public function edit(Application $application): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $application, $this->admin);

        return view('admin.career.application.edit', compact('application'));
    }

    /**
     * Update the specified application in storage.
     *
     * @param UpdateApplicationsRequest $request
     * @param Application $application
     * @return RedirectResponse
     */
    public function update(UpdateApplicationsRequest $request,
                           Application               $application): RedirectResponse
    {
        $application->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $application, $this->admin);

        return redirect()->route('admin.career.application.show', $application)
            ->with('success', 'Application successfully updated.');
    }

    /**
     * Remove the specified application from storage.
     *
     * @param Application $application
     * @return RedirectResponse
     */
    public function destroy(Application $application): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $application, $this->admin);

        $application->delete();

        return redirect(referer('admin.portfolio.application.index'))
            ->with('success', 'Application deleted successfully.');
    }

    /**
     * Create a cover letter.
     *
     * @param Application $application
     * @return Application
     */
    protected function createCoverLetter(Application $application): Application
    {
        updateGate(PermissionEntityTypes::RESOURCE, $application, $this->admin);

        if (empty($application->coverLetter)) {
            new CoverLetter()->insert([
                'owner_id'       => $application->owner_id,
                'application_id' => $application->id,
            ]);
            $application = new Application()->find($application->id);
        }

        return $application;
    }
}
