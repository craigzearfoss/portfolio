<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreOperatingSystemsRequest;
use App\Http\Requests\Dictionary\UpdateOperatingSystemsRequest;
use App\Models\Dictionary\Category;
use App\Models\Dictionary\OperatingSystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class OperatingSystemController extends BaseAdminController
{
    /**
     * Display a listing of operations systems.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'operating-system', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $operatingSystems = new Category()->searchQuery($request->all())
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view('admin.dictionary.operating-system.index', compact('operatingSystems'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new operating system.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add operating systems.');
        }

        return view('admin.dictionary.operating-system.create');
    }

    /**
     * Store a newly created operating system in storage.
     *
     * @param StoreOperatingSystemsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreOperatingSystemsRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add operating systems.');
        }

        $operatingSystem = new OperatingSystem()->create($request->validated());

        return redirect()->route('admin.dictionary.operating-system.show', $operatingSystem)
            ->with('success', $operatingSystem->name . ' successfully added.');
    }

    /**
     * Display the specified operating system.
     *
     * @param OperatingSystem $operatingSystem
     * @return View
     */
    public function show(OperatingSystem $operatingSystem): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $operatingSystem, $this->admin);

        list($prev, $next) = $operatingSystem->prevAndNextPages(
            $operatingSystem['id'],
            'admin.dictionary.operating-system.show',
            null,
            [ 'full_name', 'asc' ]
        );

        return view('admin.dictionary.operating-system.show', compact('operatingSystem', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified operating system.
     *
     * @param OperatingSystem $operatingSystem
     * @return View
     */
    public function edit(OperatingSystem $operatingSystem): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update dictionary entries.');
        }

        return view('admin.dictionary.operating-system.edit', compact('operatingSystem'));
    }

    /**
     * Update the specified operating system in storage.
     *
     * @param UpdateOperatingSystemsRequest $request
     * @param OperatingSystem $operatingSystem
     * @return RedirectResponse
     */
    public function update(UpdateOperatingSystemsRequest $request,
                           OperatingSystem               $operatingSystem): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update operating systems.');
        }

        $operatingSystem->update($request->validated());

        return redirect()->route('admin.dictionary.operating-system.show', $operatingSystem)
            ->with('success', $operatingSystem->name . ' successfully updated.');
    }

    /**
     * Remove the specified operating system from storage.
     *
     * @param OperatingSystem $operatingSystem
     * @return RedirectResponse
     */
    public function destroy(OperatingSystem $operatingSystem): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete an operating system.');
        }

        $operatingSystem->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $operatingSystem->name . ' deleted successfully.');
    }
}
