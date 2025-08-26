<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerDictionaryOperatingSystemStoreRequest;
use App\Http\Requests\CareerDictionaryOperatingSystemUpdateRequest;
use App\Models\Career\DictionaryOperatingSystem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerDictionaryOperatingSystemController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of dictionary operating systems.
     */
    public function index(): View
    {
        $dictionaryOperatingSystems = DictionaryOperatingSystem::orderBy('name', 'asc')->paginate(self::NUM_PER_PAGE);

        return view('admin.dictionary.operating_system.index', compact('dictionaryOperatingSystems'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new dictionary operating system.
     */
    public function create(): View
    {
        return view('admin.dictionary.operating_system.create');
    }

    /**
     * Store a newly created dictionary operating system in storage.
     */
    public function store(CareerDictionaryOperatingSystemStoreRequest $request): RedirectResponse
    {
        DictionaryOperatingSystem::create($request->validated());

        return redirect()->route('admin.dictionary.operating_system.index')
            ->with('success', 'Dictionary operating system created successfully.');
    }

    /**
     * Display the specified dictionary operating system.
     */
    public function show(DictionaryOperatingSystem $dictionaryOperatingSystem): View
    {
        return view('admin.dictionary.operating_system.show', compact('dictionaryOperatingSystem'));
    }

    /**
     * Show the form for editing the specified dictionary operating system.
     */
    public function edit(DictionaryOperatingSystem $dictionaryOperatingSystem): View
    {
        return view('admin.dictionary.operating_system.edit', compact('dictionaryOperatingSystem'));
    }

    /**
     * Update the specified dictionary operating system in storage.
     */
    public function update(CareerDictionaryOperatingSystemUpdateRequest $request,
                           DictionaryOperatingSystem $dictionaryOperatingSystem): RedirectResponse
    {
        $dictionaryOperatingSystem->update($request->validated());

        return redirect()->route('admin.dictionary.operating_system.index')
            ->with('success', 'Dictionary operating system updated successfully');
    }

    /**
     * Remove the specified dictionary operating system from storage.
     */
    public function destroy(DictionaryOperatingSystem $dictionaryOperatingSystem): RedirectResponse
    {
        $dictionaryOperatingSystem->delete();

        return redirect()->route('admin.dictionary.operating_system.index')
            ->with('success', 'Dictionary operating system deleted successfully');
    }
}
