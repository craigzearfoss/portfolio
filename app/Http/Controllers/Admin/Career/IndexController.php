<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\BaseController;
use App\Models\Resource;
use App\Services\PermissionService;

class IndexController extends BaseController
{
    public function index()
    {
        $careers = Resource::bySequence('career', PermissionService::ENV_ADMIN);

        return view('admin.career.index', compact('careers'));
    }
}
