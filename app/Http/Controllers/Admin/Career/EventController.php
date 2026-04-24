<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Career\StoreEventsRequest;
use App\Http\Requests\Career\UpdateEventsRequest;
use App\Models\Career\Application;
use App\Models\Career\Event;
use Exception;
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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Event::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $events = new Event()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Event::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $application = $request->application_id ? Application::query()->findOrFail($request->application_id) : null;

        $pageTitle = ($this->owner->name  ?? '') . ' Events';

        return view('admin.career.event.index', compact('events', 'application', 'pageTitle'))
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
        createGate(Event::class, $this->admin);

        $application = $request->application_id
            ? Application::query()->find($request->application_id)
            : null;

        return view('admin.career.event.create', compact('application'));
    }

    /**
     * Store a newly created event in storage.
     *
     * @param StoreEventsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreEventsRequest $request): RedirectResponse
    {
        createGate(Event::class, $this->admin);

        $applicationId = $request->query('application_id');

        if (!empty($applicationId) && (!$application = Application::query()->find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $event = Event::query()->create($request->validated());

        if ($referer = $request->query('referer')) {
            return redirect($referer)->with('success', 'Event successfully added.');
        } elseif (!empty($application)) {
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
        readGate($event, $this->admin);

        list($prev, $next) = $event->prevAndNextPages(
            $event['id'],
            'admin.career.event.show',
            $this->owner ?? null,
            [ 'event_datetime', 'desc' ]
        );

        return view('admin.career.event.show', compact('event', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified event.
     *
     * @param Event $event
     * @return View
     */
    public function edit(Event $event): View
    {
        updateGate($event, $this->admin);

        return view('admin.career.event.edit', compact('event'));
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

        if (!empty($applicationId) && (!$application = Application::query()->find($applicationId)))  {
            $previousUrl = url()->previous();
            $previousUrl = $previousUrl . '?' . http_build_query(['application_id' => $applicationId]);
            return redirect()->to($previousUrl)->with('error', 'Application `' . $applicationId . '` not found.')
                ->withInput();
        }

        $event->update($request->validated());

        updateGate($event, $this->admin);

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', 'Event successfully updated.');
        } elseif (!empty($application)) {
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
        deleteGate($event, $this->admin);

        $event->delete();

        return redirect(referer('admin.career.event.index'))
            ->with('success', 'Event deleted successfully.');
    }
}
