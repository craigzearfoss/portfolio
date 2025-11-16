<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Dictionary\StoreServersRequest;
use App\Http\Requests\Dictionary\UpdateServersRequest;
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
class ServerController extends BaseAdminController
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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add servers.');
        }

        return view('admin.dictionary.server.create');
    }

    /**
     * Store a newly created server in storage.
     *
     * @param StoreServersRequest $storeServersRequest
     * @return RedirectResponse
     */
    public function store(StoreServersRequest $storeServersRequest): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can add servers.');
        }

        $server = Server::create($storeServersRequest->validated());

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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can edit servers.');
        }

        return view('admin.dictionary.server.edit', compact('server'));
    }

    /**
     * Update the specified server in storage.
     *
     * @param UpdateServersRequest $updateServersRequest
     * @param Server $server
     * @return RedirectResponse
     */
    public function update(UpdateServersRequest $updateServersRequest, Server $server): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can update servers.');
        }

        $server->update($updateServersRequest->validated());

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
        if (!isRootAdmin()) {
            abort(403, 'Only admins with root access can delete servers.');
        }

        $server->delete();

        return redirect(referer('admin.dictionary.index'))
            ->with('success', $server->name . ' deleted successfully.');
    }
}
