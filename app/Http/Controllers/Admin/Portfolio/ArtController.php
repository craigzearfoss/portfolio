<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\ArtStoreRequest;
use App\Http\Requests\Portfolio\ArtUpdateRequest;
use App\Models\Portfolio\Art;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ArtController extends BaseController
{
    /**
     * Display a listing of art.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $arts = Art::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.art.index', compact('arts'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new art.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.art.create', compact('referer'));
    }

    /**
     * Store a newly created art in storage.
     *
     *
     * @param ArtStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ArtStoreRequest $request): RedirectResponse
    {
        $art = Art::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $art->name . ' created successfully.');
        } else {
            return redirect()->route('admin.portfolio.art.index')
                ->with('success', $art->name . ' created successfully.');
        }
    }

    /**
     * Display the specified art.
     *
     * @param Art $art
     * @return View
     */
    public function show(Art $art): View
    {
        return view('admin.portfolio.art.show', compact('art'));
    }

    /**
     * Show the form for editing the specified art.
     *
     * @param Art $art
     * @param Request $request
     * @return View
     */
    public function edit(Art $art, Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.art.edit', compact('art', 'referer'));
    }

    /**
     * Update the specified art in storage.
     *
     * @param ArtUpdateRequest $request
     * @param Art $art
     * @return RedirectResponse
     */
    public function update(ArtUpdateRequest $request, Art $art): RedirectResponse
    {
        $art->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $art->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.art.index')
                ->with('success', $art->name . ' updated successfully.');
        }
    }

    /**
     * Remove the specified art from storage.
     *
     * @param Art $art
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Art $art, Request $request): RedirectResponse
    {
        $art->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $art->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.dictionary.database.index')
                ->with('success', $art->name . ' deleted successfully.');
        }
    }
}
