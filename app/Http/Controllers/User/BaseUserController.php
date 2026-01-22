<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class BaseUserController extends BaseController
{
    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $this->setCurrentAdminAndUser();

        $this->envType = 'user';

        view()->share('envType', $this->envType);

        $resp = $this->permissionGate();
    }
}
