<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreCommunicationsRequest;
use App\Http\Requests\Career\UpdateCommunicationsRequest;
use App\Models\Career\Application;
use App\Models\Career\Communication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        readGate(Communication::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        // by default, root admins display all communications
        $owner = ($this->owner && ($this->owner['id'] !== $this->admin['id'])) ? $this->owner : null;

        $communications = new Communication()->searchQuery(request()->except('id'), $owner)
            ->orderBy('owner_id')
            ->orderBy('datetime', 'desc')
            ->paginate($perPage)->appends(request()->except('page'));

        $application = $request->application_id ? new Application()->findOrFail($request->application_id) : null;

        $pageTitle = ($owner->name  ?? '') . ' communications';

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
        createGate(Communication::class, $this->admin);

        $application = $request->application_id
            ? new Application()->find($request->application_id)
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
        createGate(Communication::class, $this->admin);

        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = new Application()->find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $communication = new Communication()->create($request->validated());

        if ($referer = $request->query('referer')) {
            return redirect($referer)->with('success', 'Communication successfully added.');
        } elseif (!empty($application)) {
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
        readGate($communication, $this->admin);

        list($prev, $next) = $communication->prevAndNextPages(
            $communication['id'],
            'admin.career.communication.show',
            $this->owner ?? null,
            [ 'datetime', 'desc' ]
        );

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
        updateGate($communication, $this->admin);

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

        if (!empty($applicationId) && (!$application = new Application()->find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $communication->update($request->validated());

        updateGate($communication, $this->admin);

        if ($referer = $request->query('referer')) {
            return redirect($referer)->with('success', 'Communication successfully updated.');
        } elseif (!empty($application)) {
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
        deleteGate($communication, $this->admin);

        $communication->delete();

        return redirect(referer('admin.career.communication.index'))
            ->with('success', 'Communication deleted successfully.');
    }
}
