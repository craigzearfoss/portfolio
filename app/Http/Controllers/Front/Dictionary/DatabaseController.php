<?php

namespace App\Http\Controllers\Front\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\DatabaseStoreRequest;
use App\Http\Requests\Dictionary\DatabaseUpdateRequest;
use App\Models\Dictionary\Database;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $perPage= $request->query('per_page', $this->perPage);

        $databases = Database::orderBy('name', 'asc')->paginate($perPage);

        return view('front.dictionary.database.index', compact('databases'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified database.
     */
    public function show(Database $database): View
    {
        return view('front.dictionary.database.show', compact('database'));
    }
}
