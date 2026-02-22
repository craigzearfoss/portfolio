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
        $candidates = new Admin()->where('public', 1)
            ->where('disabled', false)
            ->orderBy('name')
            ->paginate($perPage)->appends(request()->except('page'));

        return view(themedTemplate('guest.system.admin.index'), compact('admin', 'candidates'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * NOTE: $this->owner is set in the BaseController->initialize() method.
     *
     * @param Admin $admin
     * @return View
     * @throws Exception
     */
    public function show(Admin $admin): View
    {
        if (!empty($this->owner) && (!$this->owner['public'] || $this->owner['disabled'])) {
            abort(404);
        }

        $thisAdmin = $admin;

        $dbColumns = [
            'Portfolio' => new AdminResource()->ownerResources(
                $this->owner->id ?? null,
                EnvTypes::GUEST,
                new Database()->where('tag', 'portfolio_db')->first()->id ?? null
            ),
            'Personal' => new AdminResource()->ownerResources(
                $this->owner->id,
                EnvTypes::GUEST,
                new Database()->where('tag', 'personal_db')->first()->id ?? null
            ),
        ];

        list($prev, $next) = new Admin()->prevAndNextPages($admin->id,
            'guest.admin.show',
            $this->owner ?? null,
            ['name', 'asc']);

        return view('guest.system.admin.show',
            compact('thisAdmin', 'dbColumns', 'prev', 'next')
        );
    }
}
