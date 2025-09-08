<?php

namespace App\Http\Controllers;

use App\Services\MenuService;
use App\Services\PermissionService;

class BaseController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
}
