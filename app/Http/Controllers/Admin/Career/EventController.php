<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Http\Requests\Career\EventStoreRequest;
use App\Http\Requests\Career\EventUpdateRequest;
use App\Models\Career\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $events = Event::latest()->paginate($perPage);

        return view('admin.career.event.index', compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        return view('admin.career.event.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(EventStoreRequest $request): RedirectResponse
    {
        Event::create($request->validated());

        return redirect()->route('admin.career.event.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event): View
    {
        return view('admin.career.event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event): View
    {
        return view('admin.career.event.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(EventUpdateRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->validated());

        return redirect()->route('admin.career.event.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('admin.career.event.index')
            ->with('success', 'Event deleted successfully');
    }
}
