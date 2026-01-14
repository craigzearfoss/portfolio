<?php

namespace App\Http\Controllers\Admin\Root\Career;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Services\PermissionService;

class IndexController extends BaseAdminRootController
{
    public function index()
    {
        $databaseId = Database::where('tag', 'career_db')->first()->id ?? null;

        $careers = !empty($databaseId)
            ? Resource::getResources(PermissionService::ENV_ADMIN, $databaseId)
            : [];

        return view('admin.career.index', compact('careers'));
    }
}
