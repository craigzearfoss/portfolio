<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreLinksRequest;
use App\Http\Requests\Portfolio\UpdateLinksRequest;
use App\Models\Portfolio\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
class LinkController extends BaseAdminController
{
    /**
     * Display a listing of links.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $links = Link::orderBy('sequence', 'asc')->paginate($perPage);

        return view('admin.portfolio.link.index', compact('links'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new link.
     *
     * @return View
     */
    public function create(Request $request): View
    {
        return view('admin.portfolio.link.create');
    }

    /**
     * Store a newly created link in storage.
     *
     * @param StoreLinksRequest $storeLinksRequest
     * @return RedirectResponse
     */
    public function store(StoreLinksRequest $storeLinksRequest): RedirectResponse
    {
        $link = Link::create($storeLinksRequest->validated());

        return redirect(referer('admin.portfolio.link.index'))
            ->with('success', $link->name . ' link added successfully.');
    }

    /**
     * Display the specified link.
     *
     * @param Link $link
     * @return View
     */
    public function show(Link $link): View
    {
        return view('admin.portfolio.link.show', compact('link'));
    }

    /**
     * Show the form for editing the specified link.
     *
     * @param Link $link
     * @return View
     */
    public function edit(Link $link): View
    {
        return view('admin.portfolio.link.edit', compact('link'));
    }

    /**
     * Update the specified link in storage.
     *
     * @param UpdateLinksRequest $updateLinksRequest
     * @param Link $link
     * @return RedirectResponse
     */
    public function update(UpdateLinksRequest $updateLinksRequest, Link $link): RedirectResponse
    {
        $link->update($updateLinksRequest->validated());

        return redirect(referer('admin.portfolio.link.index'))
            ->with('success', $link->name . ' link updated successfully.');
    }

    /**
     * Remove the specified link from storage.
     *
     * @param Link $link
     * @return RedirectResponse
     */
    public function destroy(Link $link): RedirectResponse
    {
        $link->delete();

        return redirect(referer('admin.portfolio.link.index'))
            ->with('success', $link->name . ' link deleted successfully.');
    }
}
