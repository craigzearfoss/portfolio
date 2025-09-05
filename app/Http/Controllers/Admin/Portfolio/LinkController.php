<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\LinkStoreRequest;
use App\Http\Requests\Portfolio\LinkUpdateRequest;
use App\Models\Portfolio\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LinkController extends BaseController
{
    /**
     * Display a listing of links.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $links = Link::latest()->paginate($perPage);

        return view('admin.portfolio.link.index', compact('links'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new link.
     */
    public function create(): View
    {
        return view('admin.portfolio.link.create');
    }

    /**
     * Store a newly created link in storage.
     */
    public function store(LinkStoreRequest $request): RedirectResponse
    {
        Link::create($request->validated());

        return redirect()->route('admin.portfolio.link.index')
            ->with('success', 'Link created successfully.');
    }

    /**
     * Display the specified link.
     */
    public function show(Link $link): View
    {
        return view('admin.portfolio.link.show', compact('link'));
    }

    /**
     * Show the form for editing the specified link.
     */
    public function edit(Link $link): View
    {
        return view('admin.portfolio.link.edit', compact('link'));
    }

    /**
     * Update the specified link in storage.
     */
    public function update(LinkUpdateRequest $request, Link $link): RedirectResponse
    {
        $link->update($request->validated());

        return redirect()->route('admin.portfolio.link.index')
            ->with('success', 'Link updated successfully');
    }

    /**
     * Remove the specified link from storage.
     */
    public function destroy(Link $link): RedirectResponse
    {
        $link->delete();

        return redirect()->route('admin.portfolio.link.index')
            ->with('success', 'Link deleted successfully');
    }
}
