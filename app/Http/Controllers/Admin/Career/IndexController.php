<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Services\PermissionService;

class IndexController extends BaseAdminController
{
    public function index()
    {
        $databaseId = Database::where('tag', 'career_db')->first()->id ?? null;

        $careers = !empty($databaseId)
            ? Resource::ownerResources(PermissionService::ENV_ADMIN, $databaseId)
            : [];

        return view('admin.career.index', compact('careers'));
    }
}
