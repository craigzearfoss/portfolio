<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StorePhotographyRequest;
use App\Http\Requests\Portfolio\UpdatePhotographyRequest;
use App\Models\Portfolio\Photography;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class PhotographyController extends BaseAdminController
{
    /**
     * Display a listing of photos.
     *
     * @param Request $request
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $photos = Photo::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $photos = Photo::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Photos' : $this->owner->name . ' Photos';

        return view('admin.portfolio.photography.index', compact('photos', 'pageTitle'))
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
     * @param StorePhotographyRequest $request
     * @return RedirectResponse
     */
    public function store(StorePhotographyRequest $request): RedirectResponse
    {
        $photo = Photography::create($request->validated());

        return redirect()->route('admin.portfolio.photography.show', $photo)
            ->with('success', $photo->name . ' successfully added.');
    }

    /**
     * Display the specified photo.
     *
     * @param Photography $photo
     * @return View
     */
    public function show(Photography $photo): View
    {
        return view('admin.portfolio.photography.show', compact('photo'));
    }

    /**
     * Show the form for editing the specified photo.
     *
     * @param Photography $photo
     * @return View
     */
    public function edit(Photography $photo): View
    {
        Gate::authorize('update-resource', $photo);

        return view('admin.portfolio.photography.edit', compact('photo'));
    }

    /**
     * Update the specified photo in storage.
     *
     * @param UpdatePhotographyRequest $request
     * @param Photography $photo
     * @return RedirectResponse
     */
    public function update(UpdatePhotographyRequest $request, Photography $photo): RedirectResponse
    {
        Gate::authorize('update-resource', $photo);

        $photo->update($request->validated());

        return redirect()->route('admin.portfolio.photography.show', $photo)
            ->with('success', $photo->name . ' successfully updated.');
    }

    /**
     * Remove the specified photo from storage.
     *
     * @param Photography $photo
     * @return RedirectResponse
     */
    public function destroy(Photography $photo): RedirectResponse
    {
        Gate::authorize('delete-resource', $photo);

        $photo->delete();

        return redirect(referer('admin.portfolio.photography.index'))
            ->with('success', $photo->name . ' deleted successfully.');
    }
}
