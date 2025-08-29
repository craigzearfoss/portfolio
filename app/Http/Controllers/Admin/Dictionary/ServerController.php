<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionary\ServerStoreRequest;
use App\Http\Requests\Dictionary\ServerUpdateRequest;
use App\Models\Career\DictionaryServer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ServerController extends Controller
{
    const NUM_PER_PAGE = 20;

    /**
     * Display a listing of dictionary servers.
     */
    public function index(): View
    {
        $dictionaryServers = DictionaryServer::orderBy('name', 'asc')->paginate(self::NUM_PER_PAGE);

        return view('admin.dictionary.server.index', compact('dictionaryServers'))
            ->with('i', (request()->input('page', 1) - 1) * self::NUM_PER_PAGE);
    }

    /**
     * Show the form for creating a new dictionary server.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary server entries.');
        }

        return view('admin.dictionary.server.create');
    }

    /**
     * Store a newly created dictionary server in storage.
     */
    public function store(ServerStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add dictionary server entries.');
        }

        DictionaryServer::create($request->validated());

        return redirect()->route('admin.dictionary.server.index')
            ->with('success', 'Dictionary server created successfully.');
    }

    /**
     * Display the specified dictionary server.
     */
    public function show(DictionaryServer $dictionaryServer): View
    {
        return view('admin.dictionary.server.show', compact('dictionaryServer'));
    }

    /**
     * Show the form for editing the specified dictionary server.
     */
    public function edit(DictionaryServer $dictionaryServer): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit dictionary server entries.');
        }

        return view('admin.dictionary.server.edit', compact('dictionaryServer'));
    }

    /**
     * Update the specified dictionary server in storage.
     */
    public function update(ServerUpdateRequest $request,
                           DictionaryServer $dictionaryServer): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update dictionary server entries.');
        }

        $dictionaryServer->update($request->validated());

        return redirect()->route('admin.dictionary.server.index')
            ->with('success', 'Dictionary server updated successfully');
    }

    /**
     * Remove the specified dictionary server from storage.
     */
    public function destroy(DictionaryServer $dictionaryServer): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete dictionary server entries.');
        }

        $dictionaryServer->delete();

        return redirect()->route('admin.dictionary.server.index')
            ->with('success', 'Dictionary server deleted successfully');
    }
}
