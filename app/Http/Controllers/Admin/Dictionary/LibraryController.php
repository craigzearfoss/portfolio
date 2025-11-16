<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreLibrariesRequest;
use App\Http\Requests\Dictionary\UpdateLibrariesRequest;
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
class LibraryController extends BaseAdminController
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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add libraries.');
        }

        return view('admin.dictionary.library.create');
    }

    /**
     * Store a newly created library in storage.
     *
     * @param StoreLibrariesRequest $storeLibrariesRequest
     * @return RedirectResponse
     */
    public function store(StoreLibrariesRequest $storeLibrariesRequest): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add libraries.');
        }

        $library = Library::create($storeLibrariesRequest->validated());

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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can edit libraries.');
        }

        return view('admin.dictionary.library.edit', compact('library'));
    }

    /**
     * Update the specified library in storage.
     *
     * @param UpdateLibrariesRequest $updateLibrariesRequest
     * @param Library $library
     * @return RedirectResponse
     */
    public function update(UpdateLibrariesRequest $updateLibrariesRequest, Library $library): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update libraries.');
        }

        $library->update($updateLibrariesRequest->validated());

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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete libraries.');
        }

        $library->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $library->name . ' deleted successfully.');
    }
}
