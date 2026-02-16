<?php

namespace App\Http\Controllers\Guest\System;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends BaseGuestController
{
    /**
     * Display a listing of admins.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $owners = new Admin()->where('public', 1)
            ->where('disabled', false)
            ->orderBy('username')
            ->paginate($perPage)->appends(request()->except('page'));

        return view('guest.system.admin.index', compact('owners'))
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
        if (!empty($this->owner)) {

            if (!$this->owner->public || $this->owner->disabled) {
                abort(404);
            }

            $databases = new AdminDatabase()->where('owner_id', $this->owner->id)
                ->where('name', '!=', 'dictionary')
                ->where('guest', true)
                ->orderBy('sequence')->get();

            $resources = [];
            if (!empty($databases)) {
                foreach (AdminResource::ownerResources($this->owner->id) as $resource) {
                    $resources[$resource->database_id][] = $resource;
                }
            }

        } else {
            $databases = [];
            $resources = [];
        }

        return view(themedTemplate(
            'guest.system.admin.show'),
            compact('databases', 'resources')
        );
    }
}
