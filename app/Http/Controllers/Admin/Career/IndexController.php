<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Services\PermissionService;
use Illuminate\View\View;

/**
 *
 */
class IndexController extends BaseAdminController
{
    public function index()
    {
        $databaseId = Database::where('tag', 'career_db')->first()->id ?? null;

        $careers = !empty($databaseId)
            ? AdminResource::ownerResources($this->owner->id , PermissionService::ENV_ADMIN, $databaseId)
            : [];

        return view('admin.career.index', compact('careers'));
    }
}
