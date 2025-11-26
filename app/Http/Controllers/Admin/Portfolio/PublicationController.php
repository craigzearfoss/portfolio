<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StorePublicationsRequest;
use App\Http\Requests\Portfolio\UpdatePublicationsRequest;
use App\Models\Portfolio\Publication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
        $perPage = $request->query('per_page', $this->perPage);

        $publications = Publication::orderBy('title', 'asc')->paginate($perPage);

        return view('admin.portfolio.publication.index', compact('publications'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new publication.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.portfolio.publication.create');
    }

    /**
     * Store a newly created publication in storage.
     *
     * @param StorePublicationsRequest $storePublicationsRequest
     * @return RedirectResponse
     */
    public function store(StorePublicationsRequest $storePublicationsRequest): RedirectResponse
    {
        $publication = Publication::create($storePublicationsRequest->validated());

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
        return view('admin.portfolio.publication.show', compact('publication'));
    }

    /**
     * Show the form for editing the specified publication.
     *
     * @param Publication $publication
     * @return View
     */
    public function edit(Publication $publication): View
    {
        return view('admin.portfolio.publication.edit', compact('publication'));
    }

    /**
     * Update the specified publication in storage.
     *
     * @param UpdatePublicationsRequest $updatePublicationsRequest
     * @param Publication $publication
     * @return RedirectResponse
     */
    public function update(UpdatePublicationsRequest $updatePublicationsRequest, Publication $publication): RedirectResponse
    {
        $publication->update($updatePublicationsRequest->validated());

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
        $publication->delete();

        return redirect(referer('admin.portfolio.publication.index'))
            ->with('success', $publication->title . ' deleted successfully.');
    }
}
