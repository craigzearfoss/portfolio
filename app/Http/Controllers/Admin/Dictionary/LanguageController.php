<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreLanguagesRequest;
use App\Http\Requests\Dictionary\UpdateLanguagesRequest;
use App\Models\Dictionary\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class LanguageController extends BaseAdminController
{
    /**
     * Display a listing of languages.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $languages = Language::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.language.index', compact('languages'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new language.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add languages.');
        }

        return view('admin.dictionary.language.create');
    }

    /**
     * Store a newly created language in storage.
     *
     * @param StoreLanguagesRequest $storeLanguagesRequest
     * @return RedirectResponse
     */
    public function store(StoreLanguagesRequest $storeLanguagesRequest): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add languages.');
        }

        $language = Language::create($storeLanguagesRequest->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $language->name . ' added successfully.');
    }

    /**
     * Display the specified language.
     *
     * @param Language $language
     * @return View
     */
    public function show(Language $language): View
    {
        return view('admin.dictionary.language.show', compact('language'));
    }

    /**
     * Show the form for editing the specified language.
     *
     * @param Language $language
     * @return View
     */
    public function edit(Language $language): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can edit languages.');
        }

        return view('admin.dictionary.language.edit', compact('language'));
    }

    /**
     * Update the specified language in storage.
     *
     * @param UpdateLanguagesRequest $updateLanguagesRequest
     * @param Language $language
     * @return RedirectResponse
     */
    public function update(UpdateLanguagesRequest $updateLanguagesRequest, Language $language): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update languages.');
        }

        $language->update($updateLanguagesRequest->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $language->name . ' updated successfully.');
    }

    /**
     * Remove the specified language from storage.
     *
     * @param Language $language
     * @return RedirectResponse
     */
    public function destroy(Language $language): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete languages.');
        }

        $language->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $language->name . ' deleted successfully.');
    }
}
