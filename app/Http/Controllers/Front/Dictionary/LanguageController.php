<?php

namespace App\Http\Controllers\Front\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\LanguageStoreRequest;
use App\Http\Requests\Dictionary\LanguageUpdateRequest;
use App\Models\Dictionary\Language;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LanguageController extends BaseController
{
    /**
     * Display a listing of languages.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $languages = Language::where('disabled', 0)
            ->where('public', 1)
            ->where('name', '!=', 'other')
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        return view('front.dictionary.language.index', compact('languages'))
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

        return view('front.dictionary.language.show', compact('language'));
    }
}
