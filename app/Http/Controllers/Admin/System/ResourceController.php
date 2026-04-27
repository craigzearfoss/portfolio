<?php

namespace App\Http\Controllers\Admin\System;

use App\Exports\System\ResourcesExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreResourcesRequest;
use App\Http\Requests\System\UpdateResourcesRequest;
use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class ResourceController extends BaseAdminController
{
    /**
     * Display a listing of resources.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function index(Request $request): View|RedirectResponse
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }

        $perPage = $request->query('per_page', $this->perPage());

        $resources = new Resource()->searchQuery(
            $request->all(),
            request()->input('sort') ?? implode('|', Resource::SEARCH_ORDER_BY)
        )
        ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Resources';

        return view('admin.system.resource.index', compact('resources', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        abort(403, 'Resources must be added by site developers.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreResourcesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreResourcesRequest $request): RedirectResponse
    {
        abort(403, 'Resources must be added by site developers.');
    }

    /**
     * Display the specified resource.
     *
     * @param Resource $resource
     * @return View
     */
    public function show(Resource $resource): View
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }

        list($prev, $next) = $resource->prevAndNextPages(
            $resource['id'],
            'admin.system.resource.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.resource.show', compact('resource', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Resource $resource
     * @return View
     */
    public function edit(Resource $resource): View
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }

        return view('admin.system.resource.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateResourcesRequest $request
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function update(UpdateResourcesRequest $request, Resource $resource): RedirectResponse
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Not authorized.');
        }

        $resource->update($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $resource['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.system.resource.show', $resource)
                ->with('success', $resource['name'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function destroy(Resource $resource): RedirectResponse
    {
        abort(403, 'Resources cannot be deleted.');
    }

    /**
     * Export Microsoft Excel file.
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        readGate(Resource::class, $this->admin);

        $filename = request()->has('timestamp')
            ? 'resources_' . date("Y-m-d-His") . '.xlsx'
            : 'resources.xlsx';

        return Excel::download(new ResourcesExport(), $filename);
    }
}
