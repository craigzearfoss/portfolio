<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreDatabasesRequest;
use App\Http\Requests\System\UpdateDatabasesRequest;
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
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $databases = Database::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.system.database.index', compact('databases'))
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
        list($prev, $next) = Database::prevAndNextPages($database->id,
            'admin.system.database.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.system.database.show', compact('database', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified database.
     *
     * @param Database $database
     * @return View
     */
    public function edit(Database $database): View
    {
        if (!canUpdate($database, $this->admin)) {
            abort(403, 'You are not allowed to edit this database.');
        }

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
        abort(403, 'Databases must be deleted.');
    }
}
