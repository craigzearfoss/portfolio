<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Career\EventStoreRequest;
use App\Http\Requests\Career\EventUpdateRequest;
use App\Models\Career\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class EventController extends BaseController
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

        $events = Event::latest()->paginate($perPage);

        return view('admin.career.event.index', compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new event.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.career.event.create');
    }

    /**
     * Store a newly created event in storage.
     *
     * @param EventStoreRequest $request
     * @return RedirectResponse
     */
    public function store(EventStoreRequest $request): RedirectResponse
    {
        $event = Event::create($request->validated());

        return redirect(referer('admin.career.event.index'))
            ->with('success', 'Event created successfully.');
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
     * @param EventUpdateRequest $request
     * @param Event $event
     * @return RedirectResponse
     */
    public function update(EventUpdateRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->validated());

        return redirect(referer('admin.career.event.index'))
            ->with('success', 'Event updated successfully.');
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
