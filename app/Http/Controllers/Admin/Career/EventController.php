<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreEventsRequest;
use App\Http\Requests\Career\UpdateEventsRequest;
use App\Models\Career\Application;
use App\Models\Career\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class EventController extends BaseAdminController
{
    /**
     * Display a listing of events.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $applicationId = $request->application_id;
        if (!empty($applicationId)) {

            $application = Application::find($applicationId);
            $events = Event::where('application_id', $applicationId)->latest()->paginate($perPage);

        } else {

            $application = null;
            if (!empty($this->owner)) {
                $events = Event::where('owner_id', $this->owner->id)->latest()->paginate($perPage);
            } else {
                $events = Event::latest()->paginate($perPage);
            }
        }

        return view('admin.career.event.index', compact('events', 'application'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new event.
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

        return view('admin.career.event.create', compact('application', 'urlParams'));
    }

    /**
     * Store a newly created event in storage.
     *
     * @param StoreEventsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreEventsRequest $request): RedirectResponse
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

        $event = Event::create($request->validated());

        if (!empty($application)) {
            return redirect()->route('admin.career.application.show', $application)
                ->with('success', 'Event successfully added.');

        } else {
            return redirect()->route('admin.career.event.show', $event)
                ->with('success', 'Event successfully added.');
        }
    }

    /**
     * Display the specified event.
     *
     * @param Event $event
     * @return View
     */
    public function show(Event $event): View
    {
        list($prev, $next) = Event::prevAndNextPages($event->id,
            'admin.career.event.show',
            $this->owner->id ?? null,
            ['post_date', 'asc']);

        return view('admin.career.event.show', compact('event', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified event.
     *
     * @param Event $event
     * @param Request $request
     * @return View
     */
    public function edit(Event $event, Request $request): View
    {
        if (!isRootAdmin() && ($event->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('update-resource', $event);

        $urlParams = [];
        if ($applicationId = $request->get('application_id')) {
            $urlParams['application_id'] = $applicationId;
        }

        return view('admin.career.event.edit', compact('event', 'urlParams'));
    }

    /**
     * Update the specified event in storage.
     *
     * @param UpdateEventsRequest $request
     * @param Event $event
     * @return RedirectResponse
     */
    public function update(UpdateEventsRequest $request, Event $event): RedirectResponse
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

        $event->update($request->validated());

        if (!empty($application)) {
            return redirect()->route('admin.career.application.show', $application)
                ->with('success', 'Event successfully updated.');
        } else {
            return redirect()->route('admin.career.event.show', $event)
                ->with('success', 'Event successfully updated.');
        }
    }

    /**
     * Remove the specified application from storage.
     *
     * @param Event $event
     * @return RedirectResponse
     */
    public function destroy(Event $event): RedirectResponse
    {
        if (!isRootAdmin() && ($event->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('delete-resource', $event);

        $event->delete();

        return redirect(referer('admin.career.event.index'))
            ->with('success', 'Event deleted successfully.');
    }
}
