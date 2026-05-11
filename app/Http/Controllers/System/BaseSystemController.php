<?php

namespace App\Http\Controllers\System;

use App\Enums\EnvTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Services\PermissionService;

class BaseSystemController extends BaseAdminController
{
    public function __construct(PermissionService $permissionService)
    {;
        parent::__construct($permissionService);

        // only the system 'root' admin can access system pages, that is username=root
        if ($this->admin['username'] !== 'root') {
            abort(403, 'Unauthorized action.');
        }
    }
}
