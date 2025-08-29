<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionary\LibraryStoreRequest;
use App\Http\Requests\Dictionary\UpdateRequest;
use App\Models\Dictionary\Library;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LibraryController extends Controller
{
    protected $numPerPage = 20;

    /**
     * Display a listing of dictionary libraries.
     */
    public function index(): View
    {
        $dictionaryLibraries = Library::orderBy('name', 'asc')->paginate($this->numPerPage);

        return view('admin.dictionary.library.index', compact('dictionaryLibraries'))
            ->with('i', (request()->input('page', 1) - 1) * $this->numPerPage);
    }

    /**
     * Show the form for creating a new dictionary library.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary library entries.');
        }

        return view('admin.dictionary.library.create');
    }

    /**
     * Store a newly created dictionary library in storage.
     */
    public function store(LibraryStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary library entries.');
        }

        Library::create($request->validated());

        return redirect()->route('admin.dictionary.library.index')
            ->with('success', 'Dictionary library created successfully.');
    }

    /**
     * Display the specified dictionary library.
     */
    public function show(Library $dictionaryLibrary): View
    {
        return view('admin.dictionary.library.show', compact('dictionaryLibrary'));
    }

    /**
     * Show the form for editing the specified dictionary library.
     */
    public function edit(Library $dictionaryLibrary): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit dictionary library entries.');
        }

        return view('admin.dictionary.library.edit', compact('dictionaryLibrary'));
    }

    /**
     * Update the specified dictionary library in storage.
     */
    public function update(UpdateRequest $request,
                           Library       $dictionaryLibrary): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update dictionary library entries.');
        }

        $dictionaryLibrary->update($request->validated());

        return redirect()->route('admin.dictionary.library.index')
            ->with('success', 'Dictionary library updated successfully');
    }

    /**
     * Remove the specified dictionary library from storage.
     */
    public function destroy(Library $dictionaryLibrary): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete dictionary library entries.');
        }

        $dictionaryLibrary->delete();

        return redirect()->route('admin.dictionary.library.index')
            ->with('success', 'Dictionary library deleted successfully');
    }
}
