<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\EnvTypes;
use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminsRequest;
use App\Http\Requests\System\UpdateAdminsRequest;
use App\Models\System\Admin;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Owner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 *
 */
class AdminController extends BaseAdminController
{
    /**
     * Display a listing of admins.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function index(Request $request): View|RedirectResponse
    {
        readGate(PermissionEntityTypes::RESOURCE, 'admin', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

         if (empty($this->admin->root)) {
             return redirect()->route('admin.profile.show');
         } else {
             $allAdmins = Admin::searchQuery($request->all())
                 ->orderBy('username', 'asc')
                 ->paginate($perPage)->appends(request()->except('page'));
         }

        return view('admin.system.admin.index', compact('allAdmins'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return View
     */
    public function create(): View
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can add admins.');
        }

        return view('admin.system.admin.create');
    }

    /**
     * Store a newly created admin in storage.
     *
     * @param StoreAdminsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminsRequest $request): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can create new admins.');
        }

        $request->validate($request->rules());

        $admin = new Admin();
        $admin->username = $request->username;
        $admin->email    = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->disabled = $request->disabled;

        $admin->save();

        return redirect()->route('admin.system.admin.show', $admin)
            ->with('success', 'Admin ' . $admin->username . ' successfully added.');
    }

    /**
     * Display the specified admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function show(Admin $admin): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $admin, $this->admin);

        $thisAdmin = $admin;

        list($prev, $next) = Admin::prevAndNextPages($admin->id,
            'admin.system.admin.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.system.admin.show', compact('thisAdmin', 'prev', 'next'));
    }

    /**
     * Display the specified admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function profile(Admin $admin): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $admin, $this->admin);

        $thisAdmin = $admin;

        $dbColumns = [
            'Portfolio' => AdminResource::ownerResources(
                $this->owner->id ?? null,
                EnvTypes::ADMIN,
                Database::where('tag', 'portfolio_db')->first()->id ?? null
            ),
            'Personal' => AdminResource::ownerResources(
                $this->owner->id,
                EnvTypes::ADMIN,
                Database::where('tag', 'personal_db')->first()->id ?? null
            ),
        ];


        list($prev, $next) = Admin::prevAndNextPages($admin->id,
            'admin.system.admin.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.system.admin.profile',
            compact('thisAdmin', 'dbColumns', 'prev', 'next')
        );
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $admin = Admin::findOrFail($id);

        updateGate(PermissionEntityTypes::RESOURCE, $admin, $this->admin);

        return view('admin.system.admin.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     *
     * @param UpdateAdminsRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function update(UpdateAdminsRequest $request, Admin $admin): RedirectResponse
    {
        $admin->update($request->validated());

        updateGate(PermissionEntityTypes::RESOURCE, $request, $this->admin);

        if (!empty($this->owner) && ($this->owner->id == $admin->id)) {
            // @TODO: fix
            Cookie::queue(self::OWNER_ID_COOKIE, null, 60);
        }

        return redirect()->route('admin.system.admin.show', $admin)
            ->with('success', $admin->username . ' successfully updated.');
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        if (!isRootAdmin()) {
            abort(403, 'Only root admins can delete admins.');
        } elseif ($admin->id == $this->admin->id ) {
            abort(403, 'An admin cannot delete themselves.');
        }

        return redirect(referer('admin.system.admin.index'))
            ->with('success', $admin->username . ' deleted successfully.');
    }
}
