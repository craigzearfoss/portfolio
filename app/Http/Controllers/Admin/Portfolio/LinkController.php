<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\PortfolioLinkStoreRequest;
use App\Http\Requests\PortfolioLinkUpdateRequest;
use App\Models\Portfolio\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LinkController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of links.
     */
    public function index(): View
    {
        $links = Link::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.portfolio.link.index', compact('links'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
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
    public function store(PortfolioLinkStoreRequest $request): RedirectResponse
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
    public function update(PortfolioLinkUpdateRequest $request, Link $link): RedirectResponse
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
