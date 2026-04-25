<?php

namespace App\Http\Controllers\Admin\System;

use App\Exports\System\UsersExport;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreUsersRequest;
use App\Http\Requests\System\UpdateUsersRequest;
use App\Models\System\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 *
 */
class UserController extends BaseAdminController
{
    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function index(Request $request): View|RedirectResponse
    {
        if (!$this->isRootAdmin) {
            readGate(User::class, $this->user);
        }

        $perPage = $request->query('per_page', $this->perPage());

        $allUsers = new User()->searchQuery(
            $request->all(),
            request()->input('sort') ?? implode('|', User::SEARCH_ORDER_BY),
        )
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
        createGate(User::class, $this->admin);

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
        if (!isRootAdmin()) {
            abort(403, 'Only root users can create new users.');
        }

        $request->validate($request->rules());

        $user = new User();
        $user['username'] = $request['username'];
        $user['email']    = $request['email'];
        $user['password'] = Hash::make($request['password']);
        $user['disabled'] = $request['disabled'];

        $user->save();

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $user['username'] . ' successfully added.');
        } else {
            return redirect()->route('admin.system.user.show', $user)
                ->with('success', 'User ' . $user['username'] . ' successfully added.');
        }
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        readGate($user, $this->admin);

        $thisUser = $user;

        list($prev, $next) = $user->prevAndNextPages(
            $user['id'],
            'admin.system.user.show',
            $this->owner ?? null,
            [ 'name', 'asc' ]
        );

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
        updateGate($user, $this->admin);

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

        if ($referer = $request->get('referer')) {
            return redirect($referer)->with('success', $user['username'] . ' successfully updated.');
        } else {
            return redirect()->route('admin.system.user.show', $user)
                ->with('success', $user['username'] . ' successfully updated.');
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        deleteGate($user, $this->admin);

        $user->delete();

        return redirect(referer('admin.system.user.index'))
            ->with('success', $user['username'] . ' deleted successfully.');
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $filename = request()->has('timestamp')
            ? 'users_' . date("Y-m-d-His") . '.xlsx'
            : 'users.xlsx';

        return Excel::download(new UsersExport(), $filename);
    }
}
