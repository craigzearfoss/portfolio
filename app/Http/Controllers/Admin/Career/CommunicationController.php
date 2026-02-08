<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreCommunicationsRequest;
use App\Http\Requests\Career\UpdateCommunicationsRequest;
use App\Models\Career\Application;
use App\Models\Career\Communication;
use App\Models\Career\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class CommunicationController extends BaseAdminController
{
    /**
     * Display a listing of communications.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'communication', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $applicationId = $request->application_id;
        if (!empty($applicationId)) {

            $application = Application::find($applicationId);
            $communications = Communication::where('application_id', $applicationId)->latest()->paginate($perPage);

        } else {

            $application = null;
            if (!empty($this->owner)) {
                $communications = Communication::where('owner_id', $this->owner->id)->latest()->paginate($perPage);
            } else {
                $communications = Communication::latest()->paginate($perPage);
            }
        }

        return view('admin.career.communication.index', compact('communications', 'application'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new communication.
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

        return view('admin.career.communication.create', compact('application', 'urlParams'));
    }

    /**
     * Store a newly created communication in storage.
     *
     * @param StoreCommunicationsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCommunicationsRequest $request): RedirectResponse
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

        $communication = Communication::create($request->validated());

        if (!empty($application)) {
            return redirect()->route('admin.career.application.show', $application)
                ->with('success', 'Communication successfully added.');

        } else {
            return redirect()->route('admin.career.communication.show', $communication)
                ->with('success', 'Communication successfully added.');
        }
    }

    /**
     * Display the specified communication.
     *
     * @param Communication $communication
     * @return View
     */
    public function show(Communication $communication): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $communication, $this->admin);

        list($prev, $next) = Communication::prevAndNextPages($communication->id,
            'admin.career.communication.show',
            $this->owner->id ?? null,
            ['date', 'asc']);

        return view('admin.career.communication.show', compact('communication', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified communication.
     *
     * @param int $id
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function edit(int $id): View
    {
        $communication = Communication::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $communication, $this->admin);

        $urlParams = [];
        if ($applicationId = request()->get('application_id')) {
            $urlParams['application_id'] = $applicationId;
        }

        return view('admin.career.communication.edit', compact('communication', 'urlParams'));
    }

    /**
     * Update the specified communication in storage.
     *
     * @param UpdateCommunicationsRequest $request
     * @param Communication $communication
     * @return RedirectResponse
     */
    public function update(UpdateCommunicationsRequest $request,
                           Communication               $communication): RedirectResponse
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

        $communication->update($request->validated());

        if (!empty($application)) {
            return redirect()->route('admin.career.application.show', $application)
                ->with('success', 'Communication successfully updated.');
        } else {
            return redirect()->route('admin.career.communication.show', $communication)
                ->with('success', 'Communication successfully updated.');
        }
    }

    /**
     * Remove the specified communication from storage.
     *
     * @param Communication $communication
     * @return RedirectResponse
     */
    public function destroy(Communication $communication): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $communication, $this->admin);

        $communication->delete();

        return redirect(referer('admin.career.communication.index'))
            ->with('success', 'Communication deleted successfully.');
    }
}
