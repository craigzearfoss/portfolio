<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerDictionaryLanguageStoreRequest;
use App\Http\Requests\CareerDictionaryLanguageUpdateRequest;
use App\Models\Career\DictionaryLanguage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerDictionaryLanguageController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of dictionary languages.
     */
    public function index(): View
    {
        $dictionaryLanguages = DictionaryLanguage::orderBy('name', 'asc')->paginate(self::NUM_PER_PAGE);

        return view('admin.dictionary.language.index', compact('dictionaryLanguages'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new dictionary language.
     */
    public function create(): View
    {
        return view('admin.dictionary.language.create');
    }

    /**
     * Store a newly created dictionary language in storage.
     */
    public function store(CareerDictionaryLanguageStoreRequest $request): RedirectResponse
    {
        DictionaryLanguage::create($request->validated());

        return redirect()->route('admin.dictionary.language.index')
            ->with('success', 'Dictionary language created successfully.');
    }

    /**
     * Display the specified dictionary language.
     */
    public function show(DictionaryLanguage $dictionaryLanguage): View
    {
        return view('admin.dictionary.language.show', compact('dictionaryLanguage'));
    }

    /**
     * Show the form for editing the specified dictionary language.
     */
    public function edit(DictionaryLanguage $dictionaryLanguage): View
    {
        return view('admin.dictionary.language.edit', compact('dictionaryLanguage'));
    }

    /**
     * Update the specified dictionary language in storage.
     */
    public function update(CareerDictionaryLanguageUpdateRequest $request,
                           DictionaryLanguage $dictionaryLanguage): RedirectResponse
    {
        $dictionaryLanguage->update($request->validated());

        return redirect()->route('admin.dictionary.language.index')
            ->with('success', 'Dictionary language updated successfully');
    }

    /**
     * Remove the specified dictionary language from storage.
     */
    public function destroy(DictionaryLanguage $dictionaryLanguage): RedirectResponse
    {
        $dictionaryLanguage->delete();

        return redirect()->route('admin.dictionary.language.index')
            ->with('success', 'Dictionary language deleted successfully');
    }
}
