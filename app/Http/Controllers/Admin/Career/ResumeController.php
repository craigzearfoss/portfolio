<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreResumesRequest;
use App\Http\Requests\Career\UpdateResumesRequest;
use App\Models\Career\Application;
use App\Models\Career\Resume;
use App\Models\System\Admin;
use App\Services\ResumeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        readGate(PermissionEntityTypes::RESOURCE, 'resume', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $query = new Resume()->searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name', 'desc');
        if ($application = $request->application_id ? new Application()->findOrFail($request->application_id) : null) {
            $query->leftJoin(config('app.career_db').'.applications', 'applications.resume_id', '=', 'resumes.id')
                ->where('applications.id', $application->id);
        }

        $resumes = $query->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootAdmin() && !empty($this->owner_id)) ? $this->owner->name . ' Resumes' : 'Resumes';

        return view('admin.career.resume.index', compact('resumes', 'application', 'pageTitle'))
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
        createGate(PermissionEntityTypes::RESOURCE, 'resume', $this->admin);

        $application = !empty($request->application_id)
            ? new Application()->find($request->application_id)
            : null;

        return view('admin.career.resume.create', compact('application'));
    }

    /**
     * Store a newly created resume in storage.
     *
     * @param StoreResumesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreResumesRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'resume', $this->admin);

        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = new Application()->find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $resume = new Resume()->create($request->validated());

        new Application()->update(['resume_id' => $resume->id]);

        if (!empty($application)) {
            return redirect()->route('admin.career.application.show', $application)
                ->with('success', $resume->name . ' resume successfully added.');
        } else {
            return redirect()->route('admin.career.resume.show', $resume, $request->all())
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
        readGate(PermissionEntityTypes::RESOURCE, $resume, $this->admin);

        list($prev, $next) = $resume->prevAndNextPages(
            $resume['id'],
            'admin.career.resume.show',
            $this->owner ?? null,
            [ 'date', 'asc' ]
        );

        return view('admin.career.resume.show', compact('resume', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified resume.
     *
     * @param int $id
     * @param Request $request
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function edit(int $id, Request $request): View
    {
        $resume = new Resume()->findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $resume, $this->admin);

        $urlParams = [];
        if ($applicationId = request()->get('application_id')) {
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
        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = new Application()->find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $resume->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $resume, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $resume, $this->admin);

        $resume->delete();

        return redirect(referer('admin.career.resume.index'))
            ->with('success', $resume->name . ' resume deleted successfully.');
    }

    /**
     * Display the current resume.
     *
     * @param $adminId
     * @return View
     */
    public function preview($adminId = null): View
    {
        $owner = empty($adminId)
            ? $this->owner
            : new Admin()->find($adminId);

        return new ResumeService($owner, 'default')->view();
    }
}
