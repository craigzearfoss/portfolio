<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioReadingStoreRequest;
use App\Http\Requests\PortfolioReadingUpdateRequest;
use App\Models\Portfolio\Reading;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReadingController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the reading.
     */
    public function index(): View
    {
        $readings = Reading::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.reading.index', compact('readings'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new reading.
     */
    public function create(): View
    {
        return view('admin.reading.create');
    }

    /**
     * Store a newly created reading in storage.
     */
    public function store(PortfolioReadingStoreRequest $request): RedirectResponse
    {
        Reading::create($request->validated());

        return redirect()->route('admin.reading.index')
            ->with('success', 'Reading created successfully.');
    }

    /**
     * Display the specified reading.
     */
    public function show(Reading $reading): View
    {
        return view('admin.reading.show', compact('reading'));
    }

    /**
     * Show the form for editing the specified reading.
     */
    public function edit(Reading $reading): View
    {
        return view('admin.reading.edit', compact('reading'));
    }

    /**
     * Update the specified reading in storage.
     */
    public function update(PortfolioReadingUpdateRequest $request, Reading $reading): RedirectResponse
    {
        $reading->update($request->validated());

        return redirect()->route('admin.reading.index')
            ->with('success', 'Reading updated successfully');
    }

    /**
     * Remove the specified reading from storage.
     */
    public function destroy(Reading $reading): RedirectResponse
    {
        $reading->delete();

        return redirect()->route('admin.reading.index')
            ->with('success', 'Reading deleted successfully');
    }
}
