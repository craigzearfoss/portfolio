<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionary\DatabaseStoreRequest;
use App\Http\Requests\Dictionary\DatabaseUpdateRequest;
use App\Models\Career\DictionaryDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DatabaseController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of dictionary databases.
     */
    public function index(): View
    {
        $dictionaryDatabases = DictionaryDatabase::orderBy('name', 'asc')->paginate(self::NUM_PER_PAGE);

        return view('admin.dictionary.database.index', compact('dictionaryDatabases'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new dictionary database.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary database entries.');
        }

        return view('admin.dictionary.database.create');
    }

    /**
     * Store a newly created dictionary database in storage.
     */
    public function store(DatabaseStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary database entries.');
        }

        DictionaryDatabase::create($request->validated());

        return redirect()->route('admin.dictionary.database.index')
            ->with('success', 'Dictionary database created successfully.');
    }

    /**
     * Display the specified dictionary database.
     */
    public function show(DictionaryDatabase $dictionaryDatabase): View
    {
        return view('admin.dictionary.database.show', compact('dictionaryDatabase'));
    }

    /**
     * Show the form for editing the specified dictionary database.
     */
    public function edit(DictionaryDatabase $dictionaryDatabase): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit dictionary database entries.');
        }

        return view('admin.dictionary.database.edit', compact('dictionaryDatabase'));
    }

    /**
     * Update the specified dictionary database in storage.
     */
    public function update(DatabaseUpdateRequest $request,
                           DictionaryDatabase $dictionaryDatabase): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update dictionary database entries.');
        }

        $dictionaryDatabase->update($request->validated());

        return redirect()->route('admin.dictionary.database.index')
            ->with('success', 'Dictionary database updated successfully');
    }

    /**
     * Remove the specified dictionary database from storage.
     */
    public function destroy(DictionaryDatabase $dictionaryDatabase): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can de dictionary database entries.');
        }

        $dictionaryDatabase->delete();

        return redirect()->route('admin.dictionary.database.index')
            ->with('success', 'Dictionary database deleted successfully');
    }
}
