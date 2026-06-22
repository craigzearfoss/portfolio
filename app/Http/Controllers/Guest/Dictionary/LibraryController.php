<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Enums\EnvTypes;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\Library;
use App\Services\PermissionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class LibraryController extends BaseGuestController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::GUEST);

        view()->share('resourceType', 'dictionary.library');
    }

    /**
     * Display a listing of libraries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $libraries = Library::query()->where('name', '!=', 'other')
            ->where('is_public', '=', true)
            ->where('is_disabled', '=', false)
            ->where('name', '!=', 'other')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.dictionary.library.index'), compact('libraries'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified library.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$library = Library::query()->where('slug', '=', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.dictionary.library.show'), compact('library'));
    }
}
