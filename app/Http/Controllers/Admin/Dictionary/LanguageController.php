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
    const PER_PAGE = 20;

    /**
     * Display a listing of languages.
     */
    public function index(int $perPage = self::PER_PAGE): View
    {
        $languages = Language::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.language.index', compact('languages'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new language.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add language entries.');
        }

        return view('admin.dictionary.language.create');
    }

    /**
     * Store a newly created language in storage.
     */
    public function store(LanguageStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add language entries.');
        }

        Language::create($request->validated());

        return redirect()->route('admin.dictionary.language.index')
            ->with('success', 'Language created successfully.');
    }

    /**
     * Display the specified language.
     */
    public function show(Language $language): View
    {
        return view('admin.dictionary.language.show', compact('language'));
    }

    /**
     * Show the form for editing the specified language.
     */
    public function edit(Language $language): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit language entries.');
        }

        return view('admin.dictionary.language.edit', compact('language'));
    }

    /**
     * Update the specified language in storage.
     */
    public function update(LanguageUpdateRequest $request,
                           Language              $language): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update language entries.');
        }

        $language->update($request->validated());

        return redirect()->route('admin.dictionary.language.index')
            ->with('success', 'Language updated successfully');
    }

    /**
     * Remove the specified language from storage.
     */
    public function destroy(Language $language): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete language entries.');
        }

        $language->delete();

        return redirect()->route('admin.dictionary.language.index')
            ->with('success', 'Language deleted successfully');
    }
}
