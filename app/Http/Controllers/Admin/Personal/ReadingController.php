<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreReadingsRequest;
use App\Http\Requests\Personal\UpdateReadingsRequest;
use App\Models\Personal\Reading;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class ReadingController extends BaseAdminController
{
    /**
     * Display a listing of readings.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Reading::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $readings = new Reading()->searchQuery(
            request()->except('id'),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->orderBy('owner_id')
        ->orderBy('title')
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Readings';

        return view('admin.personal.reading.index', compact('readings', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new reading.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Reading::class, $this->admin);

        return view('admin.personal.reading.create');
    }

    /**
     * Store a newly created reading in storage.
     *
     * @param StoreReadingsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreReadingsRequest $request): RedirectResponse
    {
        createGate(Reading::class, $this->admin);

        $reading = Reading::query()->create($request->validated());

        return redirect()->route('admin.personal.reading.show', $reading)
            ->with('success', $reading['title'] . ' successfully added.');
    }

    /**
     * Display the specified reading.
     *
     * @param Reading $reading
     * @return View
     */
    public function show(Reading $reading): View
    {
        readGate($reading, $this->admin);

        list($prev, $next) = $reading->prevAndNextPages(
            $reading['id'],
            'admin.personal.reading.show',
            $this->owner ?? null,
            [ 'title', 'asc' ]
        );

        return view('admin.personal.reading.show', compact('reading', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified reading.
     *
     * @param Reading $reading
     * @return View
     */
    public function edit(Reading $reading): View
    {
        updateGate($reading, $this->admin);

        return view('admin.personal.reading.edit', compact('reading'));
    }

    /**
     * Update the specified reading in storage.
     *
     * @param UpdateReadingsRequest $request
     * @param Reading $reading
     * @return RedirectResponse
     */
    public function update(UpdateReadingsRequest $request, Reading $reading): RedirectResponse
    {
        $reading->update($request->validated());

        updateGate($reading, $this->admin);

        return redirect()->route('admin.personal.reading.show', $reading)
            ->with('success', $reading['title'] . ' successfully updated.');
    }

    /**
     * Remove the specified reading from storage.
     *
     * @param Reading $reading
     * @return RedirectResponse
     */
    public function destroy(Reading $reading): RedirectResponse
    {
        deleteGate($reading, $this->admin);

        $reading->delete();

        return redirect(referer('admin.personal.reading.index'))
            ->with('success', $reading['title'] . ' deleted successfully.');
    }
}
