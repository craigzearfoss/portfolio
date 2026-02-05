<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\BaseController;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class BaseGuestController extends BaseController
{
    const OWNER_ID_COOKIE = 'guest_owner_id';
    const USER_ID_COOKIE = 'guest_user_id';

    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $this->initialize('guest');

        if (isset($_GET['debug'])) {
            $this->ddDebug();
        }

        $resp = $this->permissionGate();
    }
}
