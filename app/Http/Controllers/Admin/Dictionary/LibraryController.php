<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\LibraryStoreRequest;
use App\Http\Requests\Dictionary\UpdateRequest;
use App\Models\Dictionary\Library;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LibraryController extends BaseController
{
    /**
     * Display a listing of libraries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $libraries = Library::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.library.index', compact('libraries'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new library.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add library entries.');
        }

        return view('admin.dictionary.library.create');
    }

    /**
     * Store a newly created library in storage.
     */
    public function store(LibraryStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add library entries.');
        }

        Library::create($request->validated());

        return redirect()->route('admin.dictionary.library.index')
            ->with('success', 'Library created successfully.');
    }

    /**
     * Display the specified library.
     */
    public function show(Library $library): View
    {
        return view('admin.dictionary.library.show', compact('library'));
    }

    /**
     * Show the form for editing the specified library.
     */
    public function edit(Library $library): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit library entries.');
        }

        return view('admin.dictionary.library.edit', compact('library'));
    }

    /**
     * Update the specified library in storage.
     */
    public function update(UpdateRequest $request,
                           Library       $library): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update library entries.');
        }

        $library->update($request->validated());

        return redirect()->route('admin.dictionary.library.index')
            ->with('success', 'Library updated successfully');
    }

    /**
     * Remove the specified library from storage.
     */
    public function destroy(Library $library): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete library entries.');
        }

        $library->delete();

        return redirect()->route('admin.dictionary.library.index')
            ->with('success', 'Library deleted successfully');
    }
}
