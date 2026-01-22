<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Illuminate\View\View;

class IndexController extends BaseAdminController
{
    public function index(): View
    {
        $databaseId = Database::where('tag', 'portfolio_db')->first()->id ?? null;

        $portfolios = !empty($databaseId)
            ? Resource::ownerResources(PermissionService::ENV_ADMIN, $databaseId)
            : [];

        return view('admin.portfolio.index', compact('portfolios'));
    }
}
