<?php

namespace App\Http\Controllers\Guest\System;

use App\Enums\EnvTypes;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\User;
use App\Services\PermissionService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 *
 */
class UserController extends BaseGuestController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::GUEST);

        view()->share('resourceType', 'system.user');
    }

    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return Factory|View|\Illuminate\View\View
     */
    public function index(Request $request): Factory|View|\Illuminate\View\View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $users = User::query()->orderBy('username')
            ->paginate($perPage)->appends(request()->except('page'));

        return view('guest.system.user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * @param User $user
     * @return Factory|View|\Illuminate\View\View
     */
    public function show(User $user): Factory|View|\Illuminate\View\View
    {
        if (!$user['is_public'] || $user['is_disabled']) {
            abort(404);
        }
        return view(themedTemplate('guest.system.user.show'), compact('user'));
    }
}
