<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\ReadingStoreRequest;
use App\Http\Requests\Portfolio\ReadingUpdateRequest;
use App\Models\Portfolio\Reading;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReadingController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of readings.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $readings = Reading::latest()->paginate($perPage);

        return view('admin.portfolio.reading.index', compact('readings'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new reading.
     */
    public function create(): View
    {
        return view('admin.portfolio.reading.create');
    }

    /**
     * Store a newly created reading in storage.
     */
    public function store(ReadingStoreRequest $request): RedirectResponse
    {
        Reading::create($request->validated());

        return redirect()->route('admin.portfolio.reading.index')
            ->with('success', 'Reading created successfully.');
    }

    /**
     * Display the specified reading.
     */
    public function show(Reading $reading): View
    {
        return view('admin.portfolio.reading.show', compact('reading'));
    }

    /**
     * Show the form for editing the specified reading.
     */
    public function edit(Reading $reading): View
    {
        return view('admin.portfolio.reading.edit', compact('reading'));
    }

    /**
     * Update the specified reading in storage.
     */
    public function update(ReadingUpdateRequest $request, Reading $reading): RedirectResponse
    {
        $reading->update($request->validated());

        return redirect()->route('admin.portfolio.reading.index')
            ->with('success', 'Reading updated successfully');
    }

    /**
     * Remove the specified reading from storage.
     */
    public function destroy(Reading $reading): RedirectResponse
    {
        $reading->delete();

        return redirect()->route('admin.portfolio.reading.index')
            ->with('success', 'Reading deleted successfully');
    }
}
