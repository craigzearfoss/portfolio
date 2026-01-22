<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\BaseController;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class BaseGuestController extends BaseController
{
    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $this->setCurrentAdminAndUser();

        $this->envType = 'guest';

        view()->share('envType', $this->envType);

        $resp = $this->permissionGate();
    }
}
