<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\BaseController;
use App\Services\PermissionService;
use App\Traits\GuestControllerTrait;

/**
 *
 */
class BaseGuestController extends BaseController
{
    use GuestControllerTrait;

    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService);
    }
}
