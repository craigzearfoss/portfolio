<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StoreAwardsRequest;
use App\Http\Requests\Portfolio\UpdateAwardsRequest;
use App\Models\Portfolio\Award;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PhotographyController extends Controller
{
    /**
     * Display a listing of photos.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $photos = Award::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.portfolio.award.index', compact('photos'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new photo.
     *
     * @return View
     */
    public function create(): View
    {
        if (! Gate::allows('root-only')) {
            abort(403, 'Unauthorized action.');
        }
        Gate::authorize('create-get', Auth::guard('admin')->user());
        return view('admin.portfolio.photography.create');
    }

    /**
     * Store a newly created photo in storage.
     *
     *
     * @param StoreAwardsRequest $StoreAwardsRequest
     * @return RedirectResponse
     */
    public function store(StoreAwardsRequest $StoreAwardsRequest): RedirectResponse
    {
        $photo = Award::create($StoreAwardsRequest->validated());

        return redirect()->route('admin.portfolio.photography.show', $photo)
            ->with('success', $photo->name . ' successfully added.');
    }

    /**
     * Display the specified photo.
     *
     * @param Award $photo
     * @return View
     */
    public function show(Award $photo): View
    {
        return view('admin.portfolio.photography.show', compact('photo'));
    }

    /**
     * Show the form for editing the specified photo.
     *
     * @param Award $photo
     * @return View
     */
    public function edit(Award $photo): View
    {
        return view('admin.portfolio.photography.edit', compact('photo'));
    }

    /**
     * Update the specified photo in storage.
     *
     * @param UpdateAwardsRequest $UpdateAwardsRequest
     * @param Award $photo
     * @return RedirectResponse
     */
    public function update(UpdateAwardsRequest $UpdateAwardsRequest, Award $photo): RedirectResponse
    {
        $photo->update($UpdateAwardsRequest->validated());

        return redirect()->route('admin.portfolio.photography.show', $photo)
            ->with('success', $photo->name . ' successfully updated.');
    }

    /**
     * Remove the specified photo from storage.
     *
     * @param Award $photo
     * @return RedirectResponse
     */
    public function destroy(Award $photo): RedirectResponse
    {
        $photo->delete();

        return redirect(referer('admin.portfolio.photography.index'))
            ->with('success', $photo->name . ' deleted successfully.');
    }
}
