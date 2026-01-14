<?php

namespace App\Http\Controllers\Admin\Root\System;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Http\Requests\System\StoreResourcesRequest;
use App\Http\Requests\System\UpdateResourcesRequest;
use App\Models\System\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 *
 */
class ResourceController extends BaseAdminRootController
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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        return view('admin.system.resource.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreResourcesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreResourcesRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can add new resources.');
        }

        $resource = Resource::create($request->validated());

        return redirect()->route('admin.system.resource.show', $resource)
            ->with('success', $resource->name . ' resource successfully added.');
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
        Gate::authorize('update-resource', $resource);

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
        Gate::authorize('update-resource', $resource);

        $resource->update($request->validated());

        return redirect()->route('admin.system.resource.show', $resource)
            ->with('success', $resource->name . ' resource successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function destroy(Resource $resource): RedirectResponse
    {
        Gate::authorize('delete-resource', $resource);

        $resource->delete();

        return redirect(referer('admin.system.resource.index'))
            ->with('success', $resource->name . ' resource deleted successfully.');
    }
}
