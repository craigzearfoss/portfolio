<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\PermissionEntityTypes;
use App\Http\Controllers\User\BaseUserController;
use App\Http\Requests\System\StoreUsersRequest;
use App\Http\Requests\System\UpdateUsersRequest;
use App\Models\System\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 *
 */
class UserController extends BaseUserController
{
    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function index(Request $request): View|RedirectResponse
    {
        readGate(PermissionEntityTypes::RESOURCE, 'user', $this->admin);

        $perPage = $request->query('per_page', $this->perPage());

        $allUsers = User::searchQuery($request->all())
            ->orderBy('username')
            ->paginate($perPage)->appends(request()->except('page'));

        $pageTitle = 'Users';

        return view('admin.system.user.index', compact('allUsers', 'pageTitle'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return View
     */
    public function create(): View
    {
        createGate(PermissionEntityTypes::RESOURCE, 'user', $this->admin);

        return view('admin.system.user.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param StoreUsersRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUsersRequest $request): RedirectResponse
    {
        if (!$this->isRootAdmin) {
            abort(403, 'Only root users can create new users.');
        }

        $request->validate($request->rules());

        $user = new User();
        $user->username = $request->username;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->disabled = $request->disabled;

        $user->save();

        return redirect()->route('user.user.show', $user)
            ->with('success', 'User ' . $user->username . ' successfully added.');
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        readGate(PermissionEntityTypes::RESOURCE, $user, $this->admin);

        $thisUser = $user;

        list($prev, $next) = User::prevAndNextPages($user->id,
            'admin.system.user.show',
            $this->owner->id ?? null,
            ['name', 'asc']);

        return view('admin.system.user.show', compact('thisUser', 'next', 'prev'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        updateGate(PermissionEntityTypes::RESOURCE, $user, $this->admin);

        return view('admin.system.user.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param UpdateUsersRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUsersRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('user.user.show', $user)
            ->with('success', $user->username . ' successfully updated.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        deleteGate(PermissionEntityTypes::RESOURCE, $user, $this->admin);

        $user->delete();

        return redirect(referer('admin.system.user.index'))
            ->with('success', $user->username . ' deleted successfully.');
    }
}
