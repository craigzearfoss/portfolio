<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Portfolio\LinkStoreRequest;
use App\Http\Requests\Portfolio\LinkUpdateRequest;
use App\Models\Portfolio\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 *
 */
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
        $perPage = $request->query('per_page', $this->perPage);

        $links = Link::orderBy('sequence', 'asc')->paginate($perPage);

        return view('admin.portfolio.link.index', compact('links'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new link.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.link.create', compact('referer'));
    }

    /**
     * Store a newly created link in storage.
     *
     * @param ApplicationStoreRequest $request
     * @return RedirectResponse
     */
    public function store(LinkStoreRequest $request): RedirectResponse
    {
        $link = Link::create($request->validated());

        $referer = $request->headers->get('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $link->name . ' link created successfully.');
        } else {
            return redirect()->route('admin.portfolio.link.index')
                ->with('success', $link->name . ' link created successfully.');
        }
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
     * @param Request $request
     * @return View
     */
    public function edit(Link $link): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.portfolio.link.edit', compact('link', 'referer'));
    }

    /**
     * Update the specified link in storage.
     *
     * @param LinkUpdateRequest $request
     * @param Link $link
     * @return RedirectResponse
     */
    public function update(LinkUpdateRequest $request, Link $link): RedirectResponse
    {
        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('portfolio_db.links', 'slug') ] ]);
        $link->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $link->name . ' link updated successfully.');
        } else {
            return redirect()->route('admin.portfolio.link.index')
                ->with('success', $link->name . ' link updated successfully.');
        }
    }

    /**
     * Remove the specified link from storage.
     *
     * @param Link $link
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Link $link, Request $request): RedirectResponse
    {
        $link->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $link->name . ' link deleted successfully.');
        } else {
            return redirect()->route('admin.portfolio.link.index')
                ->with('success', $link->name . ' link deleted successfully.');
        }
    }
}
