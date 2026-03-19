<?php

namespace App\Http\Controllers\Guest\System;

use App\Enums\EnvTypes;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Admin;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends BaseGuestController
{
    /**
     * Display the guest candidates page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $admin = null;
        $candidates = new Admin()->where('is_public', '=', true)
            ->where('is_disabled', '=', false)
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.system.admin.index'), compact('admin', 'candidates'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified admin.
     *
     * @param Admin $admin
     * @return View
     * @throws Exception
     */
    public function show(Admin $admin): View
    {
        if (!$admin['is_public'] || $admin['is_disabled']) {
            abort(404);
        }

        $thisAdmin = $admin;

        $dbColumns = [
            'Portfolio' => new AdminResource()->ownerResources(
                $thisAdmin,
                EnvTypes::GUEST,
                'portfolio_db'
            ),
            'Personal' => new AdminResource()->ownerResources(
                $thisAdmin,
                EnvTypes::GUEST,
                'personal_db'
            ),
        ];

        list($prev, $next) = new Admin()->prevAndNextPages(
            $admin['id'],
            'guest.admin.show',
            $thisAdmin,
            ['name', 'asc']
        );

        return view('guest.system.admin.show',
            compact('thisAdmin', 'dbColumns', 'prev', 'next')
        );
    }
}
