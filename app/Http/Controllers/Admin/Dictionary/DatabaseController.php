<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\DatabaseStoreRequest;
use App\Http\Requests\Dictionary\DatabaseUpdateRequest;
use App\Models\Dictionary\Database;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $perPage= $request->query('per_page', $this->perPage);

        $databases = Database::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.database.index', compact('databases'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new database.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add database entries.');
        }

        return view('admin.dictionary.database.create');
    }

    /**
     * Store a newly created database in storage.
     */
    public function store(DatabaseStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add database entries.');
        }

        Database::create($request->validated());

        return redirect()->route('admin.dictionary.database.index')
            ->with('success', 'Database created successfully.');
    }

    /**
     * Display the specified database.
     */
    public function show(Database $database): View
    {
        return view('admin.dictionary.database.show', compact('database'));
    }

    /**
     * Show the form for editing the specified database.
     */
    public function edit(Database $database): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit database entries.');
        }

        return view('admin.dictionary.database.edit', compact('database'));
    }

    /**
     * Update the specified database in storage.
     */
    public function update(DatabaseUpdateRequest $request,
                           Database              $database): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update database entries.');
        }

        $database->update($request->validated());

        return redirect()->route('admin.dictionary.database.index')
            ->with('success', 'Database updated successfully');
    }

    /**
     * Remove the specified database from storage.
     */
    public function destroy(Database $database): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can de database entries.');
        }

        $database->delete();

        return redirect()->route('admin.dictionary.database.index')
            ->with('success', 'Database deleted successfully');
    }
}
