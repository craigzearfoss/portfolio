<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreReadingsRequest;
use App\Http\Requests\Personal\UpdateReadingsRequest;
use App\Models\Personal\Reading;
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
     * @throws \Exception
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        //$readings = Reading::orderBy('title', 'asc')->paginate($perPage);
        $readings = Reading::searchBuilder($request->all(), ['title', 'asc'])->paginate($perPage)
            ->appends(request()->except('page'));;

        return view('admin.personal.reading.index', compact('readings'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new reading.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.personal.reading.create');
    }

    /**
     * Store a newly created reading in storage.
     *
     * @param StoreReadingsRequest $storeReadingsRequest
     * @return RedirectResponse
     */
    public function store(StoreReadingsRequest $storeReadingsRequest): RedirectResponse
    {
        $reading = Reading::create($storeReadingsRequest->validated());

        return redirect()->route('admin.personal.reading.show', $reading)
            ->with('success', $reading->title . ' successfully added.');
    }

    /**
     * Display the specified reading.
     *
     * @param Reading $reading
     * @return View
     */
    public function show(Reading $reading): View
    {
        return view('admin.personal.reading.show', compact('reading'));
    }

    /**
     * Show the form for editing the specified reading.
     *
     * @param Reading $reading
     * @return View
     */
    public function edit(Reading $reading): View
    {
        return view('admin.personal.reading.edit', compact('reading'));
    }

    /**
     * Update the specified reading in storage.
     *
     * @param UpdateReadingsRequest $updateReadingsRequest
     * @param Reading $reading
     * @return RedirectResponse
     */
    public function update(UpdateReadingsRequest $updateReadingsRequest, Reading $reading): RedirectResponse
    {
        $reading->update($updateReadingsRequest->validated());

        return redirect()->route('admin.personal.reading.show', $reading)
            ->with('success', $reading->title . ' successfully updated.');
    }

    /**
     * Remove the specified reading from storage.
     *
     * @param Reading $reading
     * @return RedirectResponse
     */
    public function destroy(Reading $reading): RedirectResponse
    {
        $reading->delete();

        return redirect(referer('admin.personal.reading.index'))
            ->with('success', $reading->title . ' deleted successfully.');
    }
}
