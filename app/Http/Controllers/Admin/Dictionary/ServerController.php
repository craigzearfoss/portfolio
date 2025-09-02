<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dictionary\ServerStoreRequest;
use App\Http\Requests\Dictionary\ServerUpdateRequest;
use App\Models\Dictionary\Server;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ServerController extends Controller
{
    /**
     * Display a listing of servers.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage= $request->query('per_page', $this->perPage);

        $servers = Server::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.server.index', compact('servers'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new server.
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add server entries.');
        }

        return view('admin.dictionary.server.create');
    }

    /**
     * Store a newly created server in storage.
     */
    public function store(ServerStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add server entries.');
        }

        Server::create($request->validated());

        return redirect()->route('admin.dictionary.server.index')
            ->with('success', 'Server created successfully.');
    }

    /**
     * Display the specified server.
     */
    public function show(Server $server): View
    {
        return view('admin.dictionary.server.show', compact('server'));
    }

    /**
     * Show the form for editing the specified server.
     */
    public function edit(Server $server): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit server entries.');
        }

        return view('admin.dictionary.server.edit', compact('server'));
    }

    /**
     * Update the specified server in storage.
     */
    public function update(ServerUpdateRequest $request,
                           Server              $server): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update server entries.');
        }

        $server->update($request->validated());

        return redirect()->route('admin.dictionary.server.index')
            ->with('success', 'Server updated successfully');
    }

    /**
     * Remove the specified server from storage.
     */
    public function destroy(Server $server): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete server entries.');
        }

        $server->delete();

        return redirect()->route('admin.dictionary.server.index')
            ->with('success', 'Server deleted successfully');
    }
}
