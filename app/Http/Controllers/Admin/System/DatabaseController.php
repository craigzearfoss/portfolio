<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreDatabaseRequest;
use App\Http\Requests\System\UpdateDatabaseRequest;
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
        return view('admin.system.database.create');
    }

    /**
     * Store a newly created database in storage.
     *
     * @param StoreDatabaseRequest $storeDatabaseRequest
     * @return RedirectResponse
     */
    public function store(StoreDatabaseRequest $storeDatabaseRequest): RedirectResponse
    {
        $database = Database::create($storeDatabaseRequest->validated());

        return redirect(referer('admin.system.database.index'))
            ->with('success', $database->name . ' database added successfully.');
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
        return view('admin.system.database.edit', compact('database'));
    }

    /**
     * Update the specified database in storage.
     *
     * @param UpdateDatabaseRequest $updateDatabaseRequest
     * @param Database $database
     * @return RedirectResponse
     */
    public function update(UpdateDatabaseRequest $updateDatabaseRequest, Database $database): RedirectResponse
    {
        $database->update($updateDatabaseRequest->validated());

        return redirect(referer('admin.system.database.index'))
            ->with('success', $database->name . ' database updated successfully.');
    }

    /**
     * Remove the specified database from storage.
     *
     * @param Database $database
     * @return RedirectResponse
     */
    public function destroy(Database $database): RedirectResponse
    {
        $database->delete();

        return redirect(referer('admin.system.database.index'))
            ->with('success', $database->name . ' database deleted successfully.');
    }
}
