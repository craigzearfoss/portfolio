<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceStoreRequest;
use App\Http\Requests\ResourceUpdateRequest;
use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ResourceController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $resources = Resource::latest()->paginate(self::NUM_PER_PAGE);

        return view('admin.resource.index', compact('resources'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.resource.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResourceStoreRequest $request): RedirectResponse
    {
        Resource::create($request->validated());

        return redirect()->route('admin.resource.index')
            ->with('success', 'Resource created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource): View
    {
        return view('admin.resource.show', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource): View
    {
        return view('admin.resource.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResourceUpdateRequest $request, Resource $resource): RedirectResponse
    {
        $resource->update($request->validated());

        return redirect()->route('admin.resource.index')
            ->with('success', 'Resource updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource): RedirectResponse
    {
        $resource->delete();

        return redirect()->route('admin.resource.index')
            ->with('success', 'Resource deleted successfully');
    }
}
