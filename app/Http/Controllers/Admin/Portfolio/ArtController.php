<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreArtRequest;
use App\Http\Requests\Portfolio\UpdateArtRequest;
use App\Models\Portfolio\Art;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class ArtController extends BaseAdminController
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
     * @return View
     */
    public function create(): View
    {
        if (! Gate::allows('root-only')) {
            abort(403, 'Unauthorized action.');
        }
        Gate::authorize('create-get', Auth::guard('admin')->user());
        return view('admin.portfolio.art.create');
    }

    /**
     * Store a newly created art in storage.
     *
     *
     * @param StoreArtRequest $storeArtRequest
     * @return RedirectResponse
     */
    public function store(StoreArtRequest $storeArtRequest): RedirectResponse
    {
        $art = Art::create($storeArtRequest->validated());

        return redirect()->route('admin.portfolio.art.show', $art)
            ->with('success', $art->name . ' successfully added.');
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
     * @return View
     */
    public function edit(Art $art): View
    {
        return view('admin.portfolio.art.edit', compact('art'));
    }

    /**
     * Update the specified art in storage.
     *
     * @param UpdateArtRequest $updateArtRequest
     * @param Art $art
     * @return RedirectResponse
     */
    public function update(UpdateArtRequest $updateArtRequest, Art $art): RedirectResponse
    {
        $art->update($updateArtRequest->validated());

        return redirect()->route('admin.portfolio.art.show', $art)
            ->with('success', $art->name . ' successfully updated.');
    }

    /**
     * Remove the specified art from storage.
     *
     * @param Art $art
     * @return RedirectResponse
     */
    public function destroy(Art $art): RedirectResponse
    {
        $art->delete();

        return redirect(referer('admin.portfolio.art.index'))
            ->with('success', $art->name . ' deleted successfully.');
    }
}
