<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\Language;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class LanguageController extends BaseGuestController
{
    /**
     * Display a listing of languages.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $languages = Language::where('name', '!=', 'other')
            ->where('public', true)
            ->where('disabled', false)
            ->where('name', '!=', 'other')
            ->orderBy('name', 'asc')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.dictionary.language.index'), compact('languages'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified language.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$language = Language::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.dictionary.language.show'), compact('language'));
    }
}
