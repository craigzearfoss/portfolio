<?php

namespace App\Http\Controllers\Admin\Root\Career;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Http\Requests\Career\StoreCommunicationsRequest;
use App\Http\Requests\Career\UpdateCommunicationsRequest;
use App\Models\Career\Application;
use App\Models\Career\Communication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class CommunicationController extends BaseAdminRootController
{
    /**
     * Display a listing of communications.
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
            $communications = Communication::where('application_id', $applicationId)->latest()->paginate($perPage);
        } else {
            $application = null;
            $communications = Communication::latest()->paginate($perPage);
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
        return view('admin.career.communication.show', compact('communication'));
    }

    /**
     * Show the form for editing the specified communication.
     *
     * @param Communication $communication
     * @param Request $request
     * @return View
     */
    public function edit(Communication $communication, Request $request): View
    {
        Gate::authorize('update-resource', $communication);

        $urlParams = [];
        if ($applicationId = $request->get('application_id')) {
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
        Gate::authorize('update-resource', $communication);

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
        Gate::authorize('delete-resource', $communication);

        $communication->delete();

        return redirect(referer('admin.career.communication.index'))
            ->with('success', 'Communication deleted successfully.');
    }
}
