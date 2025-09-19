<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Dictionary\ServerStoreRequest;
use App\Http\Requests\Dictionary\ServerUpdateRequest;
use App\Models\Dictionary\Server;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 *
 */
class ServerController extends BaseController
{
    /**
     * Display a listing of servers.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $servers = Server::orderBy('name', 'asc')->paginate($perPage);

        return view('admin.dictionary.server.index', compact('servers'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new server.
     *
     * @return View
     */
    public function create(): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add servers.');
        }

        return view('admin.dictionary.server.create');
    }

    /**
     * Store a newly created server in storage.
     *
     * @param ServerStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ServerStoreRequest $request): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can add servers.');
        }

        $server = Server::create($request->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $server->name . ' added successfully.');
    }

    /**
     * Display the specified server.
     *
     * @param Server $server
     * @return View
     */
    public function show(Server $server): View
    {
        return view('admin.dictionary.server.show', compact('server'));
    }

    /**
     * Show the form for editing the specified server.
     *
     * @param Server $server
     * @return View
     */
    public function edit(Server $server): View
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can edit servers.');
        }

        return view('admin.dictionary.server.edit', compact('server'));
    }

    /**
     * Update the specified server in storage.
     *
     * @param ServerUpdateRequest $request
     * @param Server $server
     * @return RedirectResponse
     */
    public function update(ServerUpdateRequest $request, Server $server): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can update servers.');
        }

        $server->update($request->validated());

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $server->name . ' updated successfully.');
    }

    /**
     * Remove the specified server from storage.
     *
     * @param Server $server
     * @return RedirectResponse
     */
    public function destroy(Server $server): RedirectResponse
    {
        if (!Auth::guard('admin')->user()->root) {
            abort(403, 'Only admins with root access can delete servers.');
        }

        $server->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $server->name . ' deleted successfully.');
    }
}
