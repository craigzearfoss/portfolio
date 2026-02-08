<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StorePhotographyRequest;
use App\Http\Requests\Portfolio\UpdatePhotographyRequest;
use App\Models\Portfolio\Art;
use App\Models\Portfolio\Photography;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        readGate(PermissionEntityTypes::RESOURCE, 'photography', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        if (!empty($this->owner)) {
            $photos = Photography::where('owner_id', $this->owner->id)->orderBy('name', 'asc')->paginate($perPage);
        } else {
            $photos = Photography::orderBy('name', 'asc')->paginate($perPage);
        }

        $pageTitle = empty($this->owner) ? 'Photos' : $this->owner->name . ' photos';

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
        readGate(PermissionEntityTypes::RESOURCE, $photo, $this->admin);

        list($prev, $next) = Photography::prevAndNextPages($photo->id,
            'admin.portfolio.photography.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.photography.show', compact('photo', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified photo.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $photo = Photography::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $photo, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $photo, $this->admin);

        $photo->delete();

        return redirect(referer('admin.portfolio.photography.index'))
            ->with('success', $photo->name . ' deleted successfully.');
    }
}
