<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\Library;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class LibraryController extends BaseGuestController
{
    /**
     * Display a listing of libraries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $libraries = Library::where('disabled', 0)
            ->where('public', 1)
            ->where('name', '!=', 'other')
            ->orderBy('name', 'asc')
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
        if (!$library = Library::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.dictionary.library.show'), compact('library'));
    }
}
