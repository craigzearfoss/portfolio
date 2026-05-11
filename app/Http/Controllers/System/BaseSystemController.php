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

        if (!$this->isRootAdmin) {
            abort(403, 'Unauthorized action.');
        }
    }
}
