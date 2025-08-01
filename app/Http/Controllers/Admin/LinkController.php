<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkStoreRequest;
use App\Http\Requests\LinkUpdateRequest;
use App\Models\Portfolio\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LinkController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the link.
     */
    public function index(): View
    {
        $links = Link::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.link.index', compact('links'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new link.
     */
    public function create(): View
    {
        return view('admin.link.create');
    }

    /**
     * Store a newly created link in storage.
     */
    public function store(LinkStoreRequest $request): RedirectResponse
    {
        Link::create($request->validated());

        return redirect()->route('admin.link.index')
            ->with('success', 'Link created successfully.');
    }

    /**
     * Display the specified link.
     */
    public function show(Link $link): View
    {
        return view('admin.link.show', compact('link'));
    }

    /**
     * Show the form for editing the specified link.
     */
    public function edit(Link $link)
    {
        return view('admin.link.edit', compact('link'));
    }

    /**
     * Update the specified link in storage.
     */
    public function update(LinkUpdateRequest $request, Link $link): RedirectResponse
    {
        $link->update($request->validated());

        return redirect()->route('admin.link.index')
            ->with('success', 'Link updated successfully');
    }

    /**
     * Remove the specified link from storage.
     */
    public function destroy(Link $link): RedirectResponse
    {
        $link->delete();

        return redirect()->route('admin.link.index')
            ->with('success', 'Link deleted successfully');
    }
}
