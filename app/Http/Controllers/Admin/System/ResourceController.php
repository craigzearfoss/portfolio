<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreResourcesRequest;
use App\Http\Requests\System\UpdateResourcesRequest;
use App\Models\System\Resource;
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
        $perPage = $request->query('per_page', $this->perPage());

        $resources = Resource::orderBy('database_id')->orderBy('name')->paginate($perPage);

        return view('admin.system.resource.index', compact('resources'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
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
        list($prev, $next) = Resource::prevAndNextPages($resource->id,
            'admin.system.resource.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

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
        if (!canUpdate($resource, $this->admin)) {
            abort(403, 'You are not allowed to edit this resource.');
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
        $resource->update($request->validated());

        return redirect()->route('admin.system.resource.show', $resource)
            ->with('success', $resource->name . ' successfully updated.');
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
}
