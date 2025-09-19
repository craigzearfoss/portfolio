<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ResourceStoreRequest;
use App\Http\Requests\ResourceUpdateRequest;
use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class ResourceController extends BaseController
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

        $resources = Resource::latest()->paginate($perPage);

        return view('admin.resource.index', compact('resources'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(Request $request): View
    {
        return view('admin.resource.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ResourceStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ResourceStoreRequest $request): RedirectResponse
    {
        $resource = Resource::create($request->validated());

        return redirect(referer('admin.resource.index'))
            ->with('success', $resource->name . ' resource created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Resource $resource
     * @return View
     */
    public function show(Resource $resource): View
    {
        return view('admin.resource.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Resource $resource
     * @return View
     */
    public function edit(Resource $resource): View
    {
        return view('admin.resource.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResourceUpdateRequest $request
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function update(ResourceUpdateRequest $request, Resource $resource): RedirectResponse
    {
        $resource->update($request->validated());

        return redirect(referer('admin.resource.index'))
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

        return redirect(referer('admin.resource.index'))
            ->with('success', $resource->name . ' resource deleted successfully.');
    }
}
