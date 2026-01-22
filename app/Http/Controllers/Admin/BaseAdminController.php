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
    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $this->setCurrentAdminAndUser();

        $this->envType = 'admin';

        view()->share('envType', $this->envType);

        $resp = $this->permissionGate();
    }
}
