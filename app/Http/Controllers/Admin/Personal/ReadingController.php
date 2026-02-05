<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Personal\StoreReadingsRequest;
use App\Http\Requests\Personal\UpdateReadingsRequest;
use App\Models\Personal\Ingredient;
use App\Models\Personal\Reading;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $readings = Reading::searchBuilder(
                array_merge($request->all(), ['owner_id' => $this->owner->id]),
                ['title', 'asc'])->paginate($perPage)
                ->appends(request()->except('page'));
        } else {
            $readings = Reading::searchBuilder(
                $request->all(),
                ['title', 'asc'])->paginate($perPage)
                ->appends(request()->except('page'));
        }

        $pageTitle = empty($this->owner) ? 'Readings' : $this->owner->name . ' Readings';

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
        $reading = Reading::create($request->validated());

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
        list($prev, $next) = Reading::prevAndNextPages($reading->id,
            'admin.personal.reading.show',
            $this->owner->id ?? null,
            ['title', 'asc']);

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
        if (!isRootAdmin() && ($reading->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('update-resource', $reading);

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
        if (!isRootAdmin() && ($reading->owner_id !== Auth::guard('admin')->user()->id)) {
            Abort(403, 'Not Authorized.');
        }
        //@TODO: Get authorization gate working.
        //Gate::authorize('delete-resource', $reading);

        $reading->delete();

        return redirect(referer('admin.personal.reading.index'))
            ->with('success', $reading->title . ' deleted successfully.');
    }
}
