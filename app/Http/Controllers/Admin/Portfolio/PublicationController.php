<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StorePublicationsRequest;
use App\Http\Requests\Portfolio\UpdatePublicationsRequest;
use App\Models\Portfolio\Publication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class PublicationController extends BaseAdminController
{
    /**
     * Display a listing of publications.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(Publication::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        // by default, root admins display all publications
        $owner = ($this->owner && ($this->owner['id'] !== $this->admin['id'])) ? $this->owner : null;

        $publications = new Publication()->searchQuery(request()->except('id'), $owner)
            ->orderBy('owner_id')
            ->orderBy('title')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($owner->name  ?? '') . ' Publications';

        return view('admin.portfolio.publication.index', compact('publications', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new publication.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Publication::class, $this->admin);

        return view('admin.portfolio.publication.create');
    }

    /**
     * Store a newly created publication in storage.
     *
     * @param StorePublicationsRequest $request
     * @return RedirectResponse
     */
    public function store(StorePublicationsRequest $request): RedirectResponse
    {
        createGate(Publication::class, $this->admin);

        $publication = new Publication()->create($request->validated());

        return redirect()->route('admin.portfolio.publication.show', $publication)
            ->with('success', $publication->title . ' successfully added.');
    }

    /**
     * Display the specified publication.
     *
     * @param Publication $publication
     * @return View
     */
    public function show(Publication $publication): View
    {
        readGate($publication, $this->admin);

        list($prev, $next) = $publication->prevAndNextPages(
            $publication['id'],
            'admin.portfolio.publication.show',
            $this->owner ?? null,
            [ 'title', 'asc' ]
        );

        return view('admin.portfolio.publication.show', compact('publication', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified publication.
     *
     * @param Publication $publication
     * @return View
     */
    public function edit(Publication $publication): View
    {
        updateGate($publication, $this->admin);

        return view('admin.portfolio.publication.edit', compact('publication'));
    }

    /**
     * Update the specified publication in storage.
     *
     * @param UpdatePublicationsRequest $request
     * @param Publication $publication
     * @return RedirectResponse
     */
    public function update(UpdatePublicationsRequest $request, Publication $publication): RedirectResponse
    {
        $publication->update($request->validated());

        updateGate($publication, $this->admin);

        return redirect()->route('admin.portfolio.publication.show', $publication)
            ->with('success', $publication->title . ' successfully updated.');
    }

    /**
     * Remove the specified publication from storage.
     *
     * @param Publication $publication
     * @return RedirectResponse
     */
    public function destroy(Publication $publication): RedirectResponse
    {
        deleteGate($publication, $this->admin);

        $publication->delete();

        return redirect(referer('admin.portfolio.publication.index'))
            ->with('success', $publication->title . ' deleted successfully.');
    }
}
