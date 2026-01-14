<?php

namespace App\Http\Controllers\Admin\Root\Portfolio;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Illuminate\View\View;

class IndexController extends BaseAdminRootController
{
    public function index(): View
    {
        $databaseId = Database::where('tag', 'portfolio_db')->first()->id ?? null;

        $portfolios = !empty($databaseId)
            ? Resource::getResources(PermissionService::ENV_ADMIN, $databaseId)
            : [];

        return view('admin.portfolio.index', compact('portfolios'));
    }
}
