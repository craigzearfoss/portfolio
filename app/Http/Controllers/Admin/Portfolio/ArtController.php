<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreArtRequest;
use App\Http\Requests\Portfolio\UpdateArtRequest;
use App\Models\Portfolio\Art;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        readGate(PermissionEntityTypes::RESOURCE, 'art', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $arts = new Art()->searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = (isRootAdmin() && !empty($owner_id)) ? $this->owner->name . ' Art' : 'Art';

        return view('admin.portfolio.art.index', compact('arts','pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new art.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'art', $this->admin);

        return view('admin.portfolio.art.create');
    }

    /**
     * Store a newly created art in storage.
     *
     *
     * @param StoreArtRequest $request
     * @return RedirectResponse
     */
    public function store(StoreArtRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'art', $this->admin);

        $art = new Art()->create($request->validated());

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
        readGate(PermissionEntityTypes::RESOURCE, $art, $this->admin);

        list($prev, $next) = $art->prevAndNextPages(
            $art['id'],
            'admin.portfolio.art.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.art.show', compact('art', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified art.
     *
     * @param Art $art
     * @return View
     */
    public function edit(Art $art): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $art, $this->admin);

        return view('admin.portfolio.art.edit', compact('art'));
    }

    /**
     * Update the specified art in storage.
     *
     * @param UpdateArtRequest $request
     * @param Art $art
     * @return RedirectResponse
     */
    public function update(UpdateArtRequest $request, Art $art): RedirectResponse
    {
        $art->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $art, $this->admin);

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
        deleteGate(PermissionEntityTypes::RESOURCE, $art, $this->admin);

        $art->delete();

        return redirect(referer('admin.portfolio.art.index'))
            ->with('success', $art->name . ' deleted successfully.');
    }
}
