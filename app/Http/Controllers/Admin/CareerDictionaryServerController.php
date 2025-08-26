<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerDictionaryServerStoreRequest;
use App\Http\Requests\CareerDictionaryServerUpdateRequest;
use App\Models\Career\DictionaryServer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerDictionaryServerController extends Controller
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
        return view('admin.dictionary.server.create');
    }

    /**
     * Store a newly created dictionary server in storage.
     */
    public function store(CareerDictionaryServerStoreRequest $request): RedirectResponse
    {
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
        return view('admin.dictionary.server.edit', compact('dictionaryServer'));
    }

    /**
     * Update the specified dictionary server in storage.
     */
    public function update(CareerDictionaryServerUpdateRequest $request,
                           DictionaryServer $dictionaryServer): RedirectResponse
    {
        $dictionaryServer->update($request->validated());

        return redirect()->route('admin.dictionary.server.index')
            ->with('success', 'Dictionary server updated successfully');
    }

    /**
     * Remove the specified dictionary server from storage.
     */
    public function destroy(DictionaryServer $dictionaryServer): RedirectResponse
    {
        $dictionaryServer->delete();

        return redirect()->route('admin.dictionary.server.index')
            ->with('success', 'Dictionary server deleted successfully');
    }
}
