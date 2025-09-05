<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DatabaseUpdateRequest;
use App\Http\Requests\DatabaseStoreRequest;
use App\Models\Database;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DatabaseController extends Controller
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

        $databases = Database::latest()->paginate($perPage);

        return view('admin.database.index', compact('databases'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new database.
     */
    public function create(): View
    {
        return view('admin.database.create');
    }

    /**
     * Store a newly created database in storage.
     */
    public function store(DatabaseStoreRequest $request): RedirectResponse
    {
        Database::create($request->validated());

        return redirect()->route('admin.database.index')
            ->with('success', 'Database created successfully.');
    }

    /**
     * Display the specified database.
     */
    public function show(Database $database): View
    {
        return view('admin.database.show', compact('database'));
    }

    /**
     * Show the form for editing the specified database.
     */
    public function edit(Database $database): View
    {
        return view('admin.database.edit', compact('database'));
    }

    /**
     * Update the specified database in storage.
     */
    public function update(DatabaseUpdateRequest $request, Database $database): RedirectResponse
    {
        $database->update($request->validated());

        return redirect()->route('admin.database.index')
            ->with('success', 'Database updated successfully');
    }

    /**
     * Remove the specified database from storage.
     */
    public function destroy(Database $database): RedirectResponse
    {
        $database->delete();

        return redirect()->route('admin.database.index')
            ->with('success', 'Database deleted successfully');
    }
}
