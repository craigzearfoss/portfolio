<?php

namespace App\Http\Controllers\Admin\Root\System;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Services\PermissionService;

class IndexController extends BaseAdminRootController
{
    public function index()
    {
        $databaseId = Database::where('tag', 'system_db')->first()->id ?? null;

        $systems = !empty($databaseId)
            ? Resource::getResources(PermissionService::ENV_ADMIN, $databaseId)
            : [];

        return view('admin.system.index', compact('systems'));
    }
}
