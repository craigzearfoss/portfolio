<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\StoreLibraryRequest;
use App\Http\Requests\Dictionary\UpdateRequest;
use App\Models\Dictionary\Library;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class LibraryController extends BaseController
{
    /**
     * Display a listing of libraries.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $libraries = Library::where('disabled', 0)
            ->where('public', 1)
            ->where('name', '!=', 'other')
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        return view('guest.dictionary.library.index', compact('libraries'))
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

        return view('guest.dictionary.library.show', compact('library'));
    }
}
