<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreLibrariesRequest;
use App\Http\Requests\Dictionary\UpdateLibrariesRequest;
use App\Models\Dictionary\Category;
use App\Models\Dictionary\Library;
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
class LibraryController extends BaseAdminController
{
    protected $PAGINATION_PER_PAGE = 30;

    /**
     * Display a listing of libraries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'library', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

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
     * @param StoreLibrariesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreLibrariesRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add libraries.');
        }

        $library = Library::create($request->validated());

        return redirect()->route('admin.dictionary.library.show', $library)
            ->with('success', $library->name . ' successfully added.');
    }

    /**
     * Display the specified library.
     *
     * @param Library $library
     * @return View
     */
    public function show(Library $library): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $library, $this->admin);

        list($prev, $next) = Library::prevAndNextPages($library->id,
            'admin.dictionary.library.show',
            null,
            ['full_name', 'asc']);

        return view('admin.dictionary.library.show', compact('library', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified library.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $library = Library::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $library, $this->admin);

        return view('admin.dictionary.library.edit', compact('library'));
    }

    /**
     * Update the specified library in storage.
     *
     * @param UpdateLibrariesRequest $request
     * @param Library $library
     * @return RedirectResponse
     */
    public function update(UpdateLibrariesRequest $request, Library $library): RedirectResponse
    {
        Gate::authorize('update-resource', $library);

        $library->update($request->validated());

        return redirect()->route('admin.dictionary.library.index', $library)
            ->with('success', $library->name . ' successfully updated.');
    }

    /**
     * Remove the specified library from storage.
     *
     * @param Library $library
     * @return RedirectResponse
     */
    public function destroy(Library $library): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $library, $this->admin);

        $library->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $library->name . ' deleted successfully.');
    }
}
