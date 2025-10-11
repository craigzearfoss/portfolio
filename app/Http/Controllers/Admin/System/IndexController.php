<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Resource;
use App\Services\PermissionService;

class IndexController extends BaseAdminController
{
    public function index()
    {
        $systems = Resource::bySequence('system', PermissionService::ENV_ADMIN);

        return view('admin.system.index', compact('systems'));
    }
}
