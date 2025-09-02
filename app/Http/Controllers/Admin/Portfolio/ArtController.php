<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\ArtStoreRequest;
use App\Http\Requests\Portfolio\ArtUpdateRequest;
use App\Models\Portfolio\Art;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArtController extends Controller
{
    /**
     * Display a listing of art.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $arts = Art::latest()->paginate($perPage);

        return view('admin.portfolio.art.index', compact('arts'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new art.
     */
    public function create(): View
    {
        return view('admin.portfolio.art.create');
    }

    /**
     * Store a newly created art in storage.
     */
    public function store(ArtStoreRequest $request): RedirectResponse
    {
        Art::create($request->validated());

        return redirect()->route('admin.portfolio.art.index')
            ->with('success', 'Art created successfully.');
    }

    /**
     * Display the specified art.
     */
    public function show(Art $art): View
    {
        return view('admin.portfolio.art.show', compact('art'));
    }

    /**
     * Show the form for editing the specified art.
     */
    public function edit(Art $art): View
    {
        return view('admin.portfolio.art.edit', compact('art'));
    }

    /**
     * Update the specified art in storage.
     */
    public function update(ArtUpdateRequest $request, Art $art): RedirectResponse
    {
        $art->update($request->validated());

        return redirect()->route('admin.portfolio.art.index')
            ->with('success', 'Art updated successfully');
    }

    /**
     * Remove the specified art from storage.
     */
    public function destroy(Art $art): RedirectResponse
    {
        $art->delete();

        return redirect()->route('admin.portfolio.art.index')
            ->with('success', 'Art deleted successfully');
    }
}
