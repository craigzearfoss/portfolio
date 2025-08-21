<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioArtStoreRequest;
use App\Http\Requests\PortfolioArtUpdateRequest;
use App\Models\Portfolio\Art;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioArtController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of art.
     */
    public function index(): View
    {
        $arts = Art::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.art.index', compact('arts'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new art.
     */
    public function create(): View
    {
        return view('admin.art.create');
    }

    /**
     * Store a newly created art in storage.
     */
    public function store(PortfolioArtStoreRequest $request): RedirectResponse
    {
        Art::create($request->validated());

        return redirect()->route('admin.art.index')
            ->with('success', 'Art created successfully.');
    }

    /**
     * Display the specified art.
     */
    public function show(Art $art): View
    {
        return view('admin.art.show', compact('art'));
    }

    /**
     * Show the form for editing the specified art.
     */
    public function edit(Art $art): View
    {
        return view('admin.art.edit', compact('art'));
    }

    /**
     * Update the specified art in storage.
     */
    public function update(PortfolioArtUpdateRequest $request, Art $art): RedirectResponse
    {
        $art->update($request->validated());

        return redirect()->route('admin.art.index')
            ->with('success', 'Art updated successfully');
    }

    /**
     * Remove the specified art from storage.
     */
    public function destroy(Art $art): RedirectResponse
    {
        $art->delete();

        return redirect()->route('admin.art.index')
            ->with('success', 'Art deleted successfully');
    }
}
