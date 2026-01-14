<?php

namespace App\Http\Controllers\Admin\Root;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class BaseAdminRootController extends BaseAdminController
{
    protected $permissionService;

    protected $currentAdmin;

    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService, $request);

        if (!isRootAdmin()) {
            abort(403, 'Only admins with root privileges can access this page.');
        }
    }
}
