<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\System\Admin;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class BaseAdminController extends BaseController
{
    protected $permissionService;

    protected $admin;

    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $params = Route::current()->parameters();

        if (!empty($params['admin']->id)) {

            $currentAdminId = $params['admin']->id;
            Cookie::queue('admin_current_admin_id', $currentAdminId, 60);

            $this->admin = !empty($currentAdminId)
                ? Admin::find($currentAdminId)
                : null;

        } elseif ($this->admin = getAdmin()) {

            $currentAdminId = $this->admin->id;
            Cookie::queue('admin_current_admin_id', $currentAdminId, 60);

        } else {

            $currentAdminId = Cookie::get('admin_current_admin_id', null);
            Cookie::queue('admin_current_admin_id', $currentAdminId, 60);

            $this->admin = !empty($currentAdminId)
                ? Admin::find($currentAdminId)
                : null;
        }

        view()->share('admin', $this->admin);
    }
}
