<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\ReadingStoreRequest;
use App\Http\Requests\Portfolio\ReadingUpdateRequest;
use App\Models\Portfolio\Reading;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ReadingController extends BaseController
{
    /**
     * Display a listing of readings.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $readings = Reading::orderBy('title', 'asc')->paginate($perPage);

        return view('admin.portfolio.reading.index', compact('readings'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new reading.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.reading.create', compact('referer'));
    }

    /**
     * Store a newly created reading in storage.
     *
     * @param ReadingStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ReadingStoreRequest $request): RedirectResponse
    {
        $reading = Reading::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $reading->title . ' created successfully.');
        } else {
            return redirect()->route('admin.portfolio.link.index')
                ->with('success', $reading->title . ' created successfully.');
        }
    }

    /**
     * Display the specified reading.
     *
     * @param Reading $reading
     * @return View
     */
    public function show(Reading $reading): View
    {
        return view('admin.portfolio.reading.show', compact('reading'));
    }

    /**
     * Show the form for editing the specified reading.
     *
     * @param Reading $reading
     * @param Request $request
     * @return View
     */
    public function edit(Reading $reading, Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.reading.edit', compact('reading', 'referer'));
    }

    /**
     * Update the specified reading in storage.
     *
     * @param ReadingUpdateRequest $request
     * @param Reading $reading
     * @return RedirectResponse
     */
    public function update(ReadingUpdateRequest $request, Reading $reading): RedirectResponse
    {
        $reading->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $reading->title . ' updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.link.index')
                ->with('success', $reading->title . ' updated successfully.');
        }
    }

    /**
     * Remove the specified reading from storage.
     *
     * @param Reading $reading
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Reading $reading, Request $request): RedirectResponse
    {
        $reading->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $reading->title . ' deleted successfully.');
        } else {
            return redirect()->route('admin.portfolio.reading.index')
                ->with('success', $reading->title . ' deleted successfully.');
        }
    }
}
