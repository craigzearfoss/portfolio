<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\DatabaseStoreRequest;
use App\Http\Requests\Dictionary\DatabaseUpdateRequest;
use App\Models\Dictionary\Database;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

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
        $perPage= $request->query('per_page', $this->perPage);

        $databases = Database::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.database.index', compact('databases'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new database.
     *
     * @param Request $request
     * @return View
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add database entries.');
        }

        $referer = Request()->headers->get('referer');

        return view('admin.dictionary.database.create', compact('referer'));
    }

    /**
     * Store a newly created database in storage.
     *
     * @param JobTaskStoreRequest $request
     * @return RedirectResponse
     */
    public function store(DatabaseStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add database entries.');
        }

        $database = Database::create($request->validated());

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $database->name . ' created successfully.');
        } else {
            return redirect()->route('admin.dictionary.database.index')
                ->with('success', $database->name . ' created successfully.');
        }
    }

    /**
     * Display the specified database.
     *
     * @param JobCoworker $jobCoworker
     * @return View
     */
    public function show(Database $database): View
    {
        return view('admin.dictionary.database.show', compact('database'));
    }

    /**
     * Show the form for editing the specified database.
     *
     * @param JobCoworker $jobCoworker
     * @param Request $request
     * @return View
     */
    public function edit(Database $database): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit database entries.');
        }

        $referer = $request->headers->get('referer');

        return view('admin.dictionary.database.edit', compact('database', 'referer'));
    }

    /**
     * Update the specified database in storage.
     *
     * @param JobCoworkerUpdateRequest $request
     * @param JobCoworker $jobCoworker
     * @return RedirectResponse
     */
    public function update(DatabaseUpdateRequest $request, Database $database): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update database entries.');
        }

        // Validate the posted data and generated slug.
        $validatedData = $request->validated();
        $request->merge([ 'slug' => Str::slug($validatedData['name']) ]);
        $request->validate(['slug' => [ Rule::unique('posts', 'slug') ] ]);
        $database->update($request->validated());

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $database->name . ' updated successfully.');
        } else {
            return redirect()->route('admin.dictionary.database.index')
                ->with('success', $database->name . ' updated successfully');
        }
    }

    /**
     * Remove the specified database from storage.
     *
     * @param JobCoworker $jobCoworker
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Database $database): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can de database entries.');
        }

        $database->delete();

        $referer = $request->input('referer');

        if (!empty($referer)) {
            return redirect(str_replace(config('app.url'), '', $referer))
                ->with('success', $database->name . ' deleted successfully.');
        } else {
            return redirect()->route('admin.dictionary.database.index')
                ->with('success', $database->name . ' deleted successfully');
        }
    }
}
