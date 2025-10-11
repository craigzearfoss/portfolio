<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Resource;
use App\Services\PermissionService;

class IndexController extends BaseAdminController
{
    public function index()
    {
        $personals = Resource::bySequence( 'personal', PermissionService::ENV_ADMIN);

        return view('admin.personal.index', compact('personals'));
    }
}
