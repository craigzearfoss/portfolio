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
        $perPage= $request->query('per_page', $this->perPage);

        $libraries = Library::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.library.index', compact('libraries'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new library.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add library entries.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.library.create', compact('referer'));
    }

    /**
     * Store a newly created library in storage.
     *
     * @param LibraryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(LibraryStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add library entries.');
        }

        $library = Library::create($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $library->name . ' created successfully.');
        } else {
            return redirect()->route('admin.dictionary.library.index')
                ->with('success', $library->name . ' created successfully.');
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
        return view('admin.dictionary.library.show', compact('library'));
    }

    /**
     * Show the form for editing the specified library.
     *
     * @param Library $library
     * @param Request $request
     * @return View
     */
    public function edit(Library $library, Request $request): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit library entries.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.library.edit', compact('library', 'referer'));
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
            abort(403, 'Only admins with root access can update library entries.');
        }

        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('posts', 'slug') ] ]);
        $library->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $library->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.dictionary.library.index')
                ->with('success', $library->name . ' updated successfully');
        }
    }

    /**
     * Remove the specified library from storage.
     *
     * @param Library $library
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Library $library, Request $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete library entries.');
        }

        $library->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $library->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.dictionary.library.index')
                ->with('success', $library->name . ' deleted successfully');
        }
    }
}
