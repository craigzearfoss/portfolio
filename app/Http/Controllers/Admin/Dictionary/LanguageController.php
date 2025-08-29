<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionary\LanguageStoreRequest;
use App\Http\Requests\Dictionary\LanguageUpdateRequest;
use App\Models\Dictionary\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LanguageController extends Controller
{
    protected $numPerPage = 20;

    /**
     * Display a listing of dictionary languages.
     */
    public function index(): View
    {
        $dictionaryLanguages = Language::orderBy('name', 'asc')->paginate($this->numPerPage);

        return view('admin.dictionary.language.index', compact('dictionaryLanguages'))
            ->with('i', (request()->input('page', 1) - 1) * $this->numPerPage);
    }

    /**
     * Show the form for creating a new dictionary language.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary language entries.');
        }

        return view('admin.dictionary.language.create');
    }

    /**
     * Store a newly created dictionary language in storage.
     */
    public function store(LanguageStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary language entries.');
        }

        Language::create($request->validated());

        return redirect()->route('admin.dictionary.language.index')
            ->with('success', 'Dictionary language created successfully.');
    }

    /**
     * Display the specified dictionary language.
     */
    public function show(Language $dictionaryLanguage): View
    {
        return view('admin.dictionary.language.show', compact('dictionaryLanguage'));
    }

    /**
     * Show the form for editing the specified dictionary language.
     */
    public function edit(Language $dictionaryLanguage): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit dictionary language entries.');
        }

        return view('admin.dictionary.language.edit', compact('dictionaryLanguage'));
    }

    /**
     * Update the specified dictionary language in storage.
     */
    public function update(LanguageUpdateRequest $request,
                           Language              $dictionaryLanguage): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update dictionary language entries.');
        }

        $dictionaryLanguage->update($request->validated());

        return redirect()->route('admin.dictionary.language.index')
            ->with('success', 'Dictionary language updated successfully');
    }

    /**
     * Remove the specified dictionary language from storage.
     */
    public function destroy(Language $dictionaryLanguage): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete dictionary language entries.');
        }

        $dictionaryLanguage->delete();

        return redirect()->route('admin.dictionary.language.index')
            ->with('success', 'Dictionary language deleted successfully');
    }
}
