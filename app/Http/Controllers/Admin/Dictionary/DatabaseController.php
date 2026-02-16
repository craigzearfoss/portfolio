<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreDatabasesRequest;
use App\Http\Requests\Dictionary\UpdateDatabasesRequest;
use App\Models\Dictionary\Category;
use App\Models\Dictionary\Database;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

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
        readGate(PermissionEntityTypes::RESOURCE, 'database', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $databases = Category::searchQuery($request->all())
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view('admin.dictionary.database.index', compact('databases'))
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
            abort(403, 'Only admins with root access can add databases.');
        }

        return view('admin.dictionary.database.create');
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
            abort(403, 'Only admins with root access can add databases.');
        }

        $database = new Database()->create($request->validated());

        return redirect()->route('admin.dictionary.database.show', $database)
            ->with('success', $database->name . ' successfully added.');
    }

    /**
     * Display the specified database.
     *
     * @param Database $database
     * @return View
     */
    public function show(Database $database): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $database, $this->admin);

        list($prev, $next) = Database::prevAndNextPages($database->id,
            'admin.dictionary.database.show',
            null,
            ['full_name', 'asc']);

        return view('admin.dictionary.database.show', compact('database', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified database.
     *
     * @param Database $database
     * @return View
     */
    public function edit(Database $database): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update dictionary entries.');
        }

        return view('admin.dictionary.database.edit', compact('database'));
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
            abort(403, 'Only admins with root access can update databases.');
        }

        $database->update($request->validated());

        return redirect()->route('admin.dictionary.database.show', $database)
            ->with('success', $database->name . ' successfully updated.');
    }

    /**
     * Remove the specified database from storage.
     *
     * @param Database $database
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Database $database, Request $request): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $database, $this->admin);

        $database->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $database->name . ' deleted successfully.');
    }
}
