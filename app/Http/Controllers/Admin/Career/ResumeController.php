<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreResumesRequest;
use App\Http\Requests\Career\UpdateResumesRequest;
use App\Models\Career\Application;
use App\Models\Career\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ResumeController extends BaseAdminController
{
    /**
     * Display a listing of resumes.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $applicationId = $request->application_id;
        if (!empty($applicationId)) {
            $application = Application::find($applicationId);
            $resumes = Resume::where('application_id', $applicationId)->orderBy('date', 'desc')
                ->orderby('name', 'asc')->paginate($perPage);
        } else {
            $application = null;
            $resumes = Resume::orderBy('date', 'desc')->orderby('name', 'asc')->paginate($perPage);
        }

        return view('admin.career.resume.index', compact('resumes', 'application'))
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
        $urlParams = [];
        $application = null;
        if ($applicationId = $request->get('application_id')) {
            $urlParams['application_id'] = $applicationId;
            $application = Application::find($applicationId);
        }

        return view('admin.career.resume.create', compact('application', 'urlParams'));
    }

    /**
     * Store a newly created resume in storage.
     *
     * @param StoreResumesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreResumesRequest $request): RedirectResponse
    {
        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = Application::find($applicationId)))  {
            $previousUrl = url()->previous();
            if ($applicationId) {
                $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            }
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $resume = Resume::create($request->validated());

        $application->update(['resume_id' => $resume->id]);

        if (!empty($application)) {
            return redirect()->route('admin.career.application.show', $application)
                ->with('success', $resume->name . ' resume successfully added.');
        } else {
            return redirect()->route('admin.career.resume.show', $resume, $urlParams)
                ->with('success', $resume->name . ' resume successfully added.');
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
        Gate::authorize('update-resource', $resume);

        $urlParams = [];
        if ($applicationId = $request->get('application_id')) {
            $urlParams['application_id'] = $applicationId;
        }

        return view('admin.career.resume.edit', compact('resume', 'urlParams'));
    }

    /**
     * Update the specified resume in storage.
     *
     * @param UpdateResumesRequest $request
     * @param Resume $resume
     * @return RedirectResponse
     */
    public function update(UpdateResumesRequest $request, Resume $resume): RedirectResponse
    {
        Gate::authorize('update-resource', $resume);

        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = Application::find($applicationId)))  {
            $previousUrl = url()->previous();
            if ($applicationId) {
                $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            }
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $resume->update($request->validated());


        if (!empty($application)) {
            return redirect()->route('admin.career.application.show', $application)
                ->with('success', $resume->name . ' resume successfully updated.');
        } else {
            return redirect()->route('admin.career.resume.show', $resume)
                ->with('success', $resume->name . ' resume successfully updated.');
        }
    }

    /**
     * Remove the specified resume from storage.
     *
     * @param Resume $resume
     * @return RedirectResponse
     */
    public function destroy(Resume $resume): RedirectResponse
    {
        Gate::authorize('delete-resource', $resume);

        $resume->delete();

        return redirect(referer('admin.career.resume.index'))
            ->with('success', $resume->name . ' resume deleted successfully.');
    }
}
