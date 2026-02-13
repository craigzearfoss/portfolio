<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreDatabasesRequest;
use App\Http\Requests\System\UpdateDatabasesRequest;
use App\Models\Portfolio\Video;
use App\Models\System\Admin;
use App\Models\System\Database;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class DatabaseController extends BaseAdminController
{
    /**
     * Display a listing of databases.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View|RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Not authorized.');
        }

        $perPage = $request->query('per_page', $this->perPage());

        if (empty($this->admin->root)) {
            return redirect()->route('admin.system.admin-database.show', $this->admin);
        } else {
            $databases = Database::searchQuery($request->all(), !empty($this->owner->root) ? null : $this->owner)
                ->orderBy('owner_id', 'asc')
                ->orderBy('name', 'asc')
                ->paginate($perPage)->appends(request()->except('page'));
        }

        $pageTitle = 'Databases';

        return view('admin.system.database.index', compact('databases', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new database.
     *
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function create(): View
    {
        abort(403, 'Databases must be added by site developers.');
    }

    /**
     * Store a newly created database in storage.
     *
     * @param StoreDatabasesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDatabasesRequest $request): RedirectResponse
    {
        abort(403, 'Databases must be added by site developers.');
    }

    /**
     * Display the specified database.
     *
     * @param Database $database
     * @return View
     */
    public function show(Database $database): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Not authorized.');
        }

        list($prev, $next) = Database::prevAndNextPages($database->id,
            'admin.system.database.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.system.database.show', compact('database', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified database.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Not authorized.');
        }

        $database = Database::findOrFail($id);

        return view('admin.system.database.edit', compact('database'));
    }

    /**
     * Update the specified database in storage.
     *
     * @param UpdateDatabasesRequest $request
     * @param Database $database
     * @return RedirectResponse
     */
    public function update(UpdateDatabasesRequest $request, Database $database): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Not authorized.');
        }

        $database->update($request->validated());

        return redirect()->route('admin.system.database.show', $database)
            ->with('success', $database->name . ' successfully updated.');
    }

    /**
     * Remove the specified database from storage.
     *
     * @param Database $database
     * @return RedirectResponse
     */
    public function destroy(Database $database): RedirectResponse
    {
        abort(403, 'Databases cannot be deleted.');
    }
}
