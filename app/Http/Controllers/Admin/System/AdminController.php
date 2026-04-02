<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\EnvTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreAdminsRequest;
use App\Http\Requests\System\UpdateAdminsRequest;
use App\Models\System\Admin;
use App\Models\System\AdminResource;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        readGate(Admin::class, $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

         if (empty($this->admin->is_root)) {
             return redirect()->route('admin.profile.show');
         }

         $allAdmins = new Admin()->searchQuery($request->all(), $this->singleAdminMode || !$this->isRootAdmin ? $this->admin : null)
             ->orderBy('name')
             ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Admins';

        return view('admin.system.admin.index', compact('allAdmins', 'pageTitle'))
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
        $admin['username'] = $request->username;
        $admin['email']    = $request->email;
        $admin['password'] = Hash::make($request->password);
        $admin['disabled'] = $request->disabled;

        $admin->save();

        return redirect()->route('admin.system.admin.show', $admin)
            ->with('success', 'Admin ' . $admin['username'] . ' successfully added.');
    }

    /**
     * Display the specified admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function show(Admin $admin): View
    {
        readGate($admin, $this->admin);

        $thisAdmin = $admin;

        list($prev, $next) = $admin->prevAndNextPages(
            $admin['id'],
            'admin.system.admin.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.admin.show', compact('thisAdmin', 'prev', 'next'));
    }

    /**
     * Display the specified admin.
     *
     * @param Admin $admin
     * @return View
     * @throws Exception
     */
    public function profile(Admin $admin): View
    {
        readGate($admin, $this->admin);

        $thisAdmin = $admin;

        $dbColumns = [
            'Portfolio' => new AdminResource()->ownerResources(
                $this->owner ?? null,
                EnvTypes::ADMIN,
                'portfolio_db'
            ),
            'Personal' => new AdminResource()->ownerResources(
                $this->owner ?? null,
                EnvTypes::ADMIN,
                'personal_db'
            ),
        ];

        list($prev, $next) = $admin->prevAndNextPages(
            $admin['id'],
            'admin.system.admin.profile',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

        return view('admin.system.admin.profile',
            compact('thisAdmin', 'dbColumns', 'prev', 'next')
        );
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function edit(Admin $admin): View
    {
        updateGate($admin, $this->admin);

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

        updateGate($admin, $this->admin);

        // update the owner_id cookie
        if (!empty($this->owner) && ($this->owner['id'] == $admin['id'])) {
            $this->cookieManager->setOwnerId(EnvTypes::ADMIN, $admin['id'])
                ->queueOwnerId(EnvTypes::ADMIN);
        }

        return redirect()->route('admin.system.admin.show', $admin)
            ->with('success', $admin['username'] . ' successfully updated.');
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
        } elseif ($admin['id'] == $this->admin['id'] ) {
            abort(403, 'An admin cannot delete themselves.');
        }

        return redirect(referer('admin.system.admin.index'))
            ->with('success', $admin['username'] . ' deleted successfully.');
    }

    /**
     * Display the change password page for an admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function change_password(Admin $admin): View
    {
        $thisOwner = $admin;

        return view('admin.system.admin.change-password', compact('thisOwner'));
    }

    /**
     * Update the new password for the admin.
     *
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function change_password_submit(Request $request): RedirectResponse|View
    {
        $request->validate([
            'password'         => ['required'],
            'confirm_password' => ['required', 'same:password']
        ]);

        if (Hash::check($request->password, $this->owner['password'])) {
            return redirect()->back()->with(['error' => 'You cannot use the old password again.']);
        }

        $this->owner['password'] = Hash::make($request->password);
        $this->owner['token'] = null;
        $this->owner->update();

        $referer = $request->input('referer');
        if (in_array($request->input('referer'),
            [
                route('admin.system.admin.change-password', $this->owner),
                route('admin.system.admin.change-password-submit', $this->owner)
            ]
        )) {
            $referer = route('admin.system.admin.show', $this->owner);
        }

        return redirect($referer)
            ->with(['success' => 'Admin password successfully updated.']);
    }
}
