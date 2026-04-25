<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreLibrariesRequest;
use App\Http\Requests\Dictionary\UpdateLibrariesRequest;
use App\Models\Dictionary\Library;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
        // everyone can view dictionary index pages
        //readGate(Library::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $libraries = new Library()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Library::SEARCH_ORDER_BY)
        )
        ->paginate($perPage)->appends(request()->except('page'));

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

        $library = Library::query()->create($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $library['name'] . ' successfully added.');
        } else {
            return redirect()->route('admin.dictionary.library.show', $library)
                ->with('success', $library['name'] . ' successfully added.');
        }
    }

    /**
     * Display the specified library.
     *
     * @param Library $library
     * @return View
     */
    public function show(Library $library): View
    {
        readGate($library, $this->admin);

        list($prev, $next) = $library->prevAndNextPages(
            $library['id'],
            'admin.dictionary.library.show',
            null,
            [ 'full_name', 'asc' ]
        );

        return view('admin.dictionary.library.show', compact('library', 'prev', 'next'));
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
            abort(403, 'Only admins with root access can update dictionary entries.');
        }

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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update libraries.');
        }

        $library->update($request->validated());

        if ($referer = $request->input('referer')) {
            return redirect($referer)->with('success', $library['name'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.dictionary.library.index', $library)
                ->with('success', $library['name'] . ' successfully updated.');
        }
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
            abort(403, 'Only admins with root access can delete a library.');
        }

        $library->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $library['name'] . ' deleted successfully.');
    }
}
