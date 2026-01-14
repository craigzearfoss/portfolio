<?php

namespace App\Http\Controllers\Admin\Root\System;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Http\Requests\System\StoreDatabasesRequest;
use App\Http\Requests\System\UpdateDatabasesRequest;
use App\Models\System\Database;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class DatabaseController extends BaseAdminRootController
{
    /**
     * Display a listing of databases.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $databases = Database::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.system.database.index', compact('databases'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new database.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can access this page.');
        }

        return view('admin.system.database.create');
    }

    /**
     * Store a newly created database in storage.
     *
     * @param StoreDatabasesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDatabasesRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can add new databases.');
        }

        $database = Database::create($request->validated());

        return redirect()->route('root.system.database.show', $database)
            ->with('success', $database->name . ' database successfully added.');
    }

    /**
     * Display the specified database.
     *
     * @param Database $database
     * @return View
     */
    public function show(Database $database): View
    {
        return view('admin.system.database.show', compact('database'));
    }

    /**
     * Show the form for editing the specified database.
     *
     * @param Database $database
     * @return View
     */
    public function edit(Database $database): View
    {
        Gate::authorize('update-resource', $database);

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
        Gate::authorize('update-resource', $database);

        $database->update($request->validated());

        return redirect()->route('root.system.database.show', $database)
            ->with('success', $database->name . ' database successfully updated.');
    }

    /**
     * Remove the specified database from storage.
     *
     * @param Database $database
     * @return RedirectResponse
     */
    public function destroy(Database $database): RedirectResponse
    {
        Gate::authorize('delete-resource', $database);

        $database->delete();

        return redirect(referer('root.system.database.index'))
            ->with('success', $database->name . ' database deleted successfully.');
    }
}
