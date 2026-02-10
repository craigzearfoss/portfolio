<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreLanguagesRequest;
use App\Http\Requests\Dictionary\UpdateLanguagesRequest;
use App\Models\Dictionary\Category;
use App\Models\Dictionary\Language;
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
class LanguageController extends BaseAdminController
{
    protected $PAGINATION_PER_PAGE = 30;

    /**
     * Display a listing of languages.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        readGate(PermissionEntityTypes::RESOURCE, 'language', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

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
     * @param StoreLanguagesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreLanguagesRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add languages.');
        }

        $language = Language::create($request->validated());

        return redirect()->route('admin.dictionary.language.show', $language)
            ->with('success', $language->name . ' successfully added.');
    }

    /**
     * Display the specified language.
     *
     * @param Language $language
     * @return View
     */
    public function show(Language $language): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $language, $this->admin);

        list($prev, $next) = Language::prevAndNextPages($language->id,
            'admin.dictionary.language.show',
            null,
            ['full_name', 'asc']);

        return view('admin.dictionary.language.show', compact('language', 'prev', 'next'));
    }

    /**
     * Show the form for editing the specified language.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update languages.');
        }

        $language = Language::findOrFail($id);

        return view('admin.dictionary.language.edit', compact('language'));
    }

    /**
     * Update the specified language in storage.
     *
     * @param UpdateLanguagesRequest $request
     * @param Language $language
     * @return RedirectResponse
     */
    public function update(UpdateLanguagesRequest $request, Language $language): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update frameworks.');
        }

        $language->update($request->validated());

        return redirect()->route('admin.dictionary.show', $language)
            ->with('success', $language->name . ' successfully updated.');
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
            abort(403, 'Only admins with root access can delete a lagnuage.');
        }

        $language->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $language->name . ' deleted successfully.');
    }
}
