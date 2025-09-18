<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\DatabaseStoreRequest;
use App\Http\Requests\Dictionary\DatabaseUpdateRequest;
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
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add databases.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.database.create', compact('referer'));
    }

    /**
     * Store a newly created database in storage.
     *
     * @param DatabaseStoreRequest $request
     * @return RedirectResponse
     */
    public function store(DatabaseStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add databases.');
        }

        $database = Database::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $database->name . ' created successfully.');
        } else {
            return redirect()->route('admin.dictionary.database.index')
                ->with('success', $database->name . ' created successfully.');
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
        return view('admin.dictionary.database.show', compact('database'));
    }

    /**
     * Show the form for editing the specified database.
     *
     * @param Database $database
     * @param Request $request
     * @return View
     */
    public function edit(Database $database, Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit databases.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.database.edit', compact('database', 'referer'));
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update databases.');
        }

        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('dictionary_db.databases', 'slug') ] ]);
        $database->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $database->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.dictionary.database.index')
                ->with('success', $database->name . ' updated successfully.');
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
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete databases.');
        }

        $database->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $database->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.dictionary.database.index')
                ->with('success', $database->name . ' deleted successfully.');
        }
    }
}
