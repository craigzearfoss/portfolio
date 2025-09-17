<?php

namespace App\Http\Controllers\Front\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\DatabaseStoreRequest;
use App\Http\Requests\Dictionary\DatabaseUpdateRequest;
use App\Models\Dictionary\Database;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class DatabaseController extends BaseController
{
    /**
     * Display a listing of databases.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $databases = Database::where('disabled', 0)
            ->where('public', 1)
            ->where('name', '!=', 'other')
            ->orderBy('name', 'asc')
            ->paginate($perPage);

        return view('front.dictionary.database.index', compact('databases'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified database.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        if (!$database = Database::where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view('front.dictionary.database.show', compact('database'));
    }
}
