<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class BaseUserController extends BaseController
{
    const OWNER_ID_COOKIE = 'user_owner_id';
    const USER_ID_COOKIE = 'user_user_id';

    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $this->initialize('user');

        if (isset($_GET['debug'])) {
            $this->ddDebug();
        }

        $resp = $this->permissionGate();
    }
}
