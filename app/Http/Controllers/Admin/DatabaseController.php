<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\DatabaseUpdateRequest;
use App\Http\Requests\DatabaseStoreRequest;
use App\Models\Database;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        $databases = Database::latest()->paginate($perPage);

        return view('admin.database.index', compact('databases'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new database.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.database.create', compact('referer'));
    }

    /**
     * Store a newly created database in storage.
     *
     * @param DatabaseStoreRequest $request
     * @return RedirectResponse
     */
    public function store(DatabaseStoreRequest $request): RedirectResponse
    {
        $database = Database::create($request->validated());

        $referer = $request->headers->get('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $database->name . ' database created successfully.');
        } else {
            return redirect()->route('admin.database.index')
                ->with('success', $database->name . ' database created successfully.');
        }
    }

    /**
     * Display the specified database.
     *
     * @param Database $database
     * @return View
     */
    public function show(Database $database): View
    {
        return view('admin.database.show', compact('database'));
    }

    /**
     * Show the form for editing the specified database.
     *
     * @param Database $database
     * @param Request $request
     * @return View
     */
    public function edit(Database $database): View
    {
        $referer = $request->headers->get('referer');

        return view('admin.database.edit', compact('database', 'referer'));
    }

    /**
     * Update the specified database in storage.
     *
     * @param DatabaseUpdateRequest $request
     * @param Database $database
     * @return RedirectResponse
     */
    public function update(DatabaseUpdateRequest $request, Database $database): RedirectResponse
    {
        $database->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $database->name . ' database updated successfully.');
        } else {
            return redirect()->route('admin.database.index')
                ->with('success', $database->name . ' database updated successfully.');
        }
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
        $database->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $database->name . ' database deleted successfully.');
        } else {
             return redirect()->route('admin.database.index')
                 ->with('success', $database->name . ' database deleted successfully.');
        }
    }
}
