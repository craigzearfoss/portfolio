<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Resource;
use App\Services\PermissionService;

class IndexController extends BaseAdminController
{
    public function index()
    {
        $careers = Resource::bySequence('career', PermissionService::ENV_ADMIN);

        return view('admin.career.index', compact('careers'));
    }
}
