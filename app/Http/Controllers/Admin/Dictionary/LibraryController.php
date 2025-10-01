<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\LibraryStoreRequest;
use App\Http\Requests\Dictionary\LibraryUpdateRequest;
use App\Models\Dictionary\Library;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
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
        $perPage = $request->query('per_page', $this->perPage);

        $libraries = Library::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.library.index', compact('libraries'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new library.
     *
     * @return View
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add libraries.');
        }

        return view('admin.dictionary.library.create');
    }

    /**
     * Store a newly created library in storage.
     *
     * @param LibraryStoreRequest $libraryStoreRequest
     * @return RedirectResponse
     */
    public function store(LibraryStoreRequest $libraryStoreRequest): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add libraries.');
        }

        $library = Library::create($libraryStoreRequest->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $library->name . ' added successfully.');
    }

    /**
     * Display the specified library.
     *
     * @param Library $library
     * @return View
     */
    public function show(Library $library): View
    {
        return view('admin.dictionary.library.show', compact('library'));
    }

    /**
     * Show the form for editing the specified library.
     *
     * @param Library $library
     * @return View
     */
    public function edit(Library $library): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit libraries.');
        }

        return view('admin.dictionary.library.edit', compact('library'));
    }

    /**
     * Update the specified library in storage.
     *
     * @param LibraryUpdateRequest $request
     * @param Library $library
     * @return RedirectResponse
     */
    public function update(LibraryUpdateRequest $request, Library $library): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update libraries.');
        }

        $library->update($request->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $library->name . ' updated successfully.');
    }

    /**
     * Remove the specified library from storage.
     *
     * @param Library $library
     * @return RedirectResponse
     */
    public function destroy(Library $library): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete libraries.');
        }

        $library->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $library->name . ' deleted successfully.');
    }
}
