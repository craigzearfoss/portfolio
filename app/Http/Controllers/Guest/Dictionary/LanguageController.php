<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Enums\EnvTypes;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\Language;
use App\Services\PermissionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class LanguageController extends BaseGuestController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::GUEST);

        view()->share('resourceType', 'dictionary.language');
    }

    /**
     * Display a listing of languages.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $languages = Language::query()->where('name', '!=', 'other')
            ->where('is_public', '=', true)
            ->where('is_disabled', '=', false)
            ->where('name', '!=', 'other')
            ->orderBy('name')
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
        if (!$language = Language::query()->where('slug', '=', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.dictionary.language.show'), compact('language'));
    }
}
