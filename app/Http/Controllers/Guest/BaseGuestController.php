<?php

namespace App\Http\Controllers\Guest;

use App\Enums\EnvTypes;
use App\Http\Controllers\BaseController;
use App\Services\PermissionService;

class BaseGuestController extends BaseController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::GUEST);
    }
}
