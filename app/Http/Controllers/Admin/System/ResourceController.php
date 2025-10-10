<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreResourceRequest;
use App\Http\Requests\System\UpdateResourceRequest;
use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class ResourceController extends BaseAdminController
{
    /**
     * Display a listing of resources.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $resources = Resource::orderBy('name')->paginate($perPage);

        return view('admin.system.resource.index', compact('resources'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(Request $request): View
    {
        return view('admin.system.resource.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreResourceRequest $storeResourceRequest
     * @return RedirectResponse
     */
    public function store(StoreResourceRequest $storeResourceRequest): RedirectResponse
    {
        $resource = Resource::create($storeResourceRequest->validated());

        return redirect(referer('admin.system.resource.index'))
            ->with('success', $resource->name . ' resource added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Resource $resource
     * @return View
     */
    public function show(Resource $resource): View
    {
        return view('admin.system.resource.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Resource $resource
     * @return View
     */
    public function edit(Resource $resource): View
    {
        return view('admin.system.resource.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateResourceRequest $updateResourceRequest
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function update(UpdateResourceRequest $updateResourceRequest, Resource $resource): RedirectResponse
    {
        $resource->update($updateResourceRequest->validated());

        return redirect(referer('admin.system.resource.index'))
            ->with('success', $resource->name . ' resource updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function destroy(Resource $resource): RedirectResponse
    {
        $resource->delete();

        return redirect(referer('admin.system.resource.index'))
            ->with('success', $resource->name . ' resource deleted successfully.');
    }
}
