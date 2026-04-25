<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Exports\Portfolio\LinksExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Portfolio\StoreLinksRequest;
use App\Http\Requests\Portfolio\UpdateLinksRequest;
use App\Models\Portfolio\Link;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @throws Exception
     */
    public function index(Request $request): View
    {
        readGate(Link::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $links = new Link()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Link::SEARCH_ORDER_BY),
            $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = ($this->owner->name  ?? '') . ' Links';

        return view('admin.portfolio.link.index', compact('links', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new link.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(Link::class, $this->admin);

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
        createGate(Link::class, $this->admin);

        $link = Link::query()->create($request->validated());

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $link['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.portfolio.link.show', $link)
                ->with('success', $link->name . ' link successfully added.');
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
        readGate($link, $this->admin);

        list($prev, $next) = $link->prevAndNextPages(
            $link['id'],
            'admin.portfolio.link.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.portfolio.link.show', compact('link', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified link.
     *
     * @param Link $link
     * @return View
     */
    public function edit(Link $link): View
    {
        updateGate($link, $this->admin);

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

        updateGate($link, $this->admin);

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $link['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.portfolio.link.show', $link)
                ->with('success', $link->name . ' link successfully updated.');
        }
    }

    /**
     * Remove the specified link from storage.
     *
     * @param Link $link
     * @return RedirectResponse
     */
    public function destroy(Link $link): RedirectResponse
    {
        deleteGate($link, $this->admin);

        $link->delete();

        return redirect(referer('admin.portfolio.link.index'))
            ->with('success', $link->name . ' link deleted successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $filename = request()->has('timestamp')
            ? 'links_' . date("Y-m-d-His") . '.xlsx'
            : 'links.xlsx';

        return Excel::download(new LinksExport(), $filename);
    }
}
