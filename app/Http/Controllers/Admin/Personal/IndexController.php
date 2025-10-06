<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\BaseController;
use App\Models\Resource;
use App\Services\PermissionService;

class IndexController extends BaseController
{
    public function index()
    {
        $personals = Resource::bySequence( 'personal', PermissionService::ENV_ADMIN);

        return view('admin.personal.index', compact('personals'));
    }
}
