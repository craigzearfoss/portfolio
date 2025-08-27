<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerDictionaryLibraryStoreRequest;
use App\Http\Requests\CareerDictionaryLibraryUpdateRequest;
use App\Models\Career\DictionaryLibrary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CareerDictionaryLibraryController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of dictionary libraries.
     */
    public function index(): View
    {
        $dictionaryLibraries = DictionaryLibrary::orderBy('name', 'asc')->paginate(self::NUM_PER_PAGE);

        return view('admin.dictionary.library.index', compact('dictionaryLibraries'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
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
    public function store(CareerDictionaryLibraryStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary library entries.');
        }

        DictionaryLibrary::create($request->validated());

        return redirect()->route('admin.dictionary.library.index')
            ->with('success', 'Dictionary library created successfully.');
    }

    /**
     * Display the specified dictionary library.
     */
    public function show(DictionaryLibrary $dictionaryLibrary): View
    {
        return view('admin.dictionary.library.show', compact('dictionaryLibrary'));
    }

    /**
     * Show the form for editing the specified dictionary library.
     */
    public function edit(DictionaryLibrary $dictionaryLibrary): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit dictionary library entries.');
        }

        return view('admin.dictionary.library.edit', compact('dictionaryLibrary'));
    }

    /**
     * Update the specified dictionary library in storage.
     */
    public function update(CareerDictionaryLibraryUpdateRequest $request,
                           DictionaryLibrary $dictionaryLibrary): RedirectResponse
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
    public function destroy(DictionaryLibrary $dictionaryLibrary): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete dictionary library entries.');
        }

        $dictionaryLibrary->delete();

        return redirect()->route('admin.dictionary.library.index')
            ->with('success', 'Dictionary library deleted successfully');
    }
}
