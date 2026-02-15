<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreLinksRequest;
use App\Http\Requests\Portfolio\UpdateLinksRequest;
use App\Models\Portfolio\Link;
use App\Models\System\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        readGate(PermissionEntityTypes::RESOURCE, 'link', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $links = Link::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
            ->orderBy('owner_id')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->isRootAdmin && !empty($owner_id)) ? $this->owner->name . ' Links' : 'Links';

        return view('admin.portfolio.link.index', compact('links', 'pageTitle'))
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
        createGate(PermissionEntityTypes::RESOURCE, 'link', $this->admin);

        return view('admin.portfolio.link.create');
    }

    /**
     * Store a newly created link in storage.
     *
     * @param StoreLinksRequest $request
     * @return RedirectResponse
     */
    public function store(StoreLinksRequest $request): RedirectResponse
    {
        createGate(PermissionEntityTypes::RESOURCE, 'link', $this->admin);

        $link = Link::create($request->validated());

        return redirect()->route('admin.portfolio.link.show', $link)
            ->with('success', $link->name . ' link successfully added.');
    }

    /**
     * Display the specified link.
     *
     * @param Link $link
     * @return View
     */
    public function show(Link $link): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $link, $this->admin);

        list($prev, $next) = Link::prevAndNextPages($link->id,
            'admin.portfolio.link.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.portfolio.link.show', compact('link', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified link.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $link = Link::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $link, $this->admin);

        return view('admin.portfolio.link.edit', compact('link'));
    }

    /**
     * Update the specified link in storage.
     *
     * @param UpdateLinksRequest $request
     * @param Link $link
     * @return RedirectResponse
     */
    public function update(UpdateLinksRequest $request, Link $link): RedirectResponse
    {
        $link->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $link, $this->admin);

        return redirect()->route('admin.portfolio.link.show', $link)
            ->with('success', $link->name . ' link successfully updated.');
    }

    /**
     * Remove the specified link from storage.
     *
     * @param Link $link
     * @return RedirectResponse
     */
    public function destroy(Link $link): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $link, $this->admin);

        $link->delete();

        return redirect(referer('admin.portfolio.link.index'))
            ->with('success', $link->name . ' link deleted successfully.');
    }
}
