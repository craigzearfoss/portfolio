<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\BaseCoreController;
use App\Models\System\Admin;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class BaseGuestController extends BaseCoreController
{
    protected $permissionService;

    protected $admin;

    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        if (Route::current()) {

            $params = Route::current()->parameters();
            if (!empty($params['admin']->id)) {
                Cookie::queue('guest_admin_id', $params['admin']->id, $minutes = 60);
            }

        } else {

            //$adminId = Cookie::get('guest.admin_id', null);
            //dd($adminId);
        }
        /*
        if ($adminId = $request->cookie('guest.admin_id')) {

        }
dd($request->ge );
        $this->admin = Admin::find(45);

dd($request->cookie('guest.admin_id'));
*/
    }
}
