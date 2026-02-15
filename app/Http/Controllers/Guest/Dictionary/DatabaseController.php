<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\Database;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class DatabaseController extends BaseGuestController
{
    /**
     * Display a listing of databases.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $databases = new Database()->where('name', '!=', 'other')
            ->where('public', true)
            ->where('disabled', false)
            ->where('name', '!=', 'other')
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.dictionary.database.index'), compact('databases'))
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
        if (!$database = new Database()->where('slug', $slug)->first()) {
            throw new ModelNotFoundException();
        }

        return view(themedTemplate('guest.dictionary.database.show'), compact('database'));
    }
}
