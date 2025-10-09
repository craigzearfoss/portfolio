<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\StoreDatabaseRequest;
use App\Http\Requests\Dictionary\UpdateDatabaseRequest;
use App\Models\Dictionary\Database;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class DatabaseController extends BaseController
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add databases.');
        }

        return view('admin.dictionary.database.create');
    }

    /**
     * Store a newly created database in storage.
     *
     * @param StoreDatabaseRequest $storeDatabaseRequest
     * @return RedirectResponse
     */
    public function store(StoreDatabaseRequest $storeDatabaseRequest): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add databases.');
        }

        $database = Database::create($storeDatabaseRequest->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $database->name . ' added successfully.');
    }

    /**
     * Display the specified database.
     *
     * @param Database $database
     * @return View
     */
    public function show(Database $database): View
    {
        return view('admin.dictionary.database.show', compact('database'));
    }

    /**
     * Show the form for editing the specified database.
     *
     * @param Database $database
     * @return View
     */
    public function edit(Database $database): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit databases.');
        }

        return view('admin.dictionary.database.edit', compact('database'));
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update databases.');
        }

        $database->update($updateDatabaseRequest->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $database->name . ' updated successfully.');
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete databases.');
        }

        $database->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $database->name . ' deleted successfully.');
    }
}
