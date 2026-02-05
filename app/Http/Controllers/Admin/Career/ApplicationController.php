<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreApplicationsRequest;
use App\Http\Requests\Career\UpdateApplicationsRequest;
use App\Models\Career\Application;
use App\Models\Career\Communication;
use App\Models\Career\Company;
use App\Models\Career\CoverLetter;
use App\Models\Career\Event;
use App\Models\Career\Note;
use App\Models\Career\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        $perPage = $request->query('per_page', $this->perPage());

        $resumeId = $request->resume_id;
        if (!empty($resumeId)) {

            $resume = Resume::find($resumeId);
            $applications = Application::where('resume_id', $resumeId)->latest()->paginate($perPage);

        } else {

            $resume = null;
            if (!empty($this->owner)) {
                $applications = Application::where('owner_id', $this->owner->id)->latest()->paginate($perPage);
            } else {
                $applications = Application::latest()->paginate($perPage);
            }
        }


        return view('admin.career.application.index', compact('applications', 'resume'))
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
        $errorMessages = [];
        $urlParams = [];

        if ($companyId = $request->query('company_id')) {
            $urlParams['company_id'] = $companyId;
            if (!Company::find($companyId)) {
                $errorMessages[] = "Company `$companyId` not found.";
            }
        }

        if ($resumeId = $request->query('resume_id')) {
            $urlParams['resume_id'] = $resumeId;
            if (!Resume::find($resumeId)) {
                $errorMessages[] = "Resume `$resumeId` not found.";
            }
        }

        if ($coverLetterId = $request->query('cover_letter_id')) {
            $urlParams['cover_letter_id'] = $coverLetterId;
            if (!CoverLetter::find($coverLetterId)) {
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
        $application = Application::create($request->validated());

        // Create a cover letter for the application.
        CoverLetter::insert([
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
        if (empty($application->coverLetter)) {
            $application = $this->createCoverLetter($application);
        }

        list($prev, $next) = Application::prevAndNextPages($application->id,
            'admin.career.application.show',
            $this->owner->id ?? null,
            ['post_date', 'asc']);

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
        if (!isRootAdmin() && ($application->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('update-resource', $application);

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
        if (!isRootAdmin() && ($application->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('delete-resource', $application);

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
