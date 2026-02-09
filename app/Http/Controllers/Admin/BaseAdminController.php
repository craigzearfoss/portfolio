<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EnvTypes;
use App\Http\Controllers\BaseController;
use App\Models\System\Admin;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

class BaseAdminController extends BaseController
{
    const OWNER_ID_COOKIE = 'admin_owner_id';
    const USER_ID_COOKIE = 'admin_user_id';

    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $this->initialize(EnvTypes::ADMIN);

        if (isset($_GET['debug'])) {
            //$this->ddDebug();
        }
    }
}
