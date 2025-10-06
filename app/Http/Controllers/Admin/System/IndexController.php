<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\BaseController;
use App\Models\Resource;
use App\Services\PermissionService;

class IndexController extends BaseController
{
    public function index()
    {
        $systems = Resource::bySequence('system', PermissionService::ENV_ADMIN);

        return view('admin.system.index', compact('systems'));
    }
}
