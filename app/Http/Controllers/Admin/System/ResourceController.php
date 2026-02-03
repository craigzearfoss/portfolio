<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Resource;
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

        $resources = Resource::orderBy('name')->paginate($perPage);

        return view('admin.system.resource.index', compact('resources'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
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
}
