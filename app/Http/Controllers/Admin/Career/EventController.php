<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreEventsRequest;
use App\Http\Requests\Career\UpdateEventsRequest;
use App\Models\Career\Application;
use App\Models\Career\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $perPage = $request->query('per_page', $this->perPage);

        $applicationId = $request->application_id;
        if (!empty($applicationId)) {
            $application = Application::find($applicationId);
            $events = Event::where('application_id', $applicationId)->latest()->paginate($perPage);
        } else {
            $application = null;
            $events = Event::latest()->paginate($perPage);
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
        $applicationId = $request->application_id;
        $application = !empty($applicationId)
            ? Application::find($applicationId)
            : null;

        return view('admin.career.event.create', compact('application'));
    }

    /**
     * Store a newly created event in storage.
     *
     * @param StoreEventsRequest $storeEventsRequest
     * @return RedirectResponse
     */
    public function store(StoreEventsRequest $storeEventsRequest): RedirectResponse
    {
        $event = Event::create($storeEventsRequest->validated());

        return redirect()->route('admin.career.event.show', $event)
            ->with('success', 'Event successfully added.');
    }

    /**
     * Display the specified event.
     *
     * @param Event $event
     * @return View
     */
    public function show(Event $event): View
    {
        return view('admin.career.event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     *
     * @param Event $event
     * @return View
     */
    public function edit(Event $event): View
    {
        return view('admin.career.event.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     *
     * @param UpdateEventsRequest $updateEventsRequest
     * @param Event $event
     * @return RedirectResponse
     */
    public function update(UpdateEventsRequest $updateEventsRequest, Event $event): RedirectResponse
    {
        $event->update($updateEventsRequest->validated());

        return redirect()->route('admin.career.event.show', $event)
            ->with('success', 'Event successfully updated.');
    }

    /**
     * Remove the specified application from storage.
     *
     * @param Event $event
     * @return RedirectResponse
     */
    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect(referer('admin.career.event.index'))
            ->with('success', 'Event deleted successfully.');
    }
}
