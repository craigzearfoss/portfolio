<?php

namespace App\Http\Controllers\Admin\Root\Personal;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Services\PermissionService;

class IndexController extends BaseAdminRootController
{
    public function index()
    {
        $databaseId = Database::where('tag', 'personal_db')->first()->id ?? null;

        $personals = !empty($databaseId)
            ? Resource::getResources(PermissionService::ENV_ADMIN, $databaseId)
            : [];

        return view('admin.personal.index', compact('personals'));
    }
}
