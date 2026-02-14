<?php

namespace App\Http\Controllers\Admin\Career;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreCommunicationsRequest;
use App\Http\Requests\Career\UpdateCommunicationsRequest;
use App\Models\Career\Application;
use App\Models\Career\Communication;
use App\Models\Career\Resume;
use App\Models\System\Owner;
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

        $query = Communication::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('date', 'desc');
        if ($application = $request->application_id ? Application::findOrFail($request->application_id) : null) {
            $query->where('application_id', $application->id);
        }

        $communications = $query->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($this->owner_id)) ? $this->owner->name . ' Communications' : 'Communications';

        return view('admin.career.communication.index', compact('communications', 'application', 'pageTitle'))
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
        createGate(PermissionEntityTypes::RESOURCE, 'communication', $this->admin);

        $application = !empty($request->application_id)
            ? Application::find($request->application_id)
            : null;

        return view('admin.career.communication.create', compact('application'));
    }

    /**
     * Store a newly created communication in storage.
     *
     * @param StoreCommunicationsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCommunicationsRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'communication', $this->admin);

        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = Application::find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
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
     * @param Communication $communication
     * @return View
     */
    public function edit(Communication $communication): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $communication, $this->admin);

        return view('admin.career.communication.edit', compact('communication'));
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

        updateGate(PermissionEntityTypes::RESOURCE, $communication, $this->admin);

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
