<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\BaseController;
use App\Models\System\Admin;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class BaseGuestController extends BaseController
{
    protected $permissionService;

    protected $currentAdmin;

    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        if (Route::current()) {

            $params = Route::current()->parameters();
            if (!empty($params['admin']->id)) {
                $currentAdminId = $params['admin']->id;
                Cookie::queue('guest_current_admin_id', $currentAdminId, 60);
            }

        } else {

            $currentAdminId = Cookie::get('guest_current_admin_id', null);
        }

        $this->currentAdmin = !empty($currentAdminId)
            ? Admin::find($currentAdminId)
            : null;

        view()->share('currentAdmin', $this->currentAdmin);
    }
}
