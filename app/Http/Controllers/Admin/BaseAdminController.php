<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EnvTypes;
use App\Http\Controllers\BaseController;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class BaseAdminController extends BaseController
{
    const string OWNER_ID_COOKIE = 'admin_owner_id';
    const string USER_ID_COOKIE = 'admin_user_id';

    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $this->initialize(EnvTypes::ADMIN);

        /*
        if (isset($_GET['debug'])) {
            $this->ddDebug();
        }
        */
    }
}
