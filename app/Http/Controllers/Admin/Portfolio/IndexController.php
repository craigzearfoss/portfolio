<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Resource;
use App\Services\PermissionService;

class IndexController extends BaseAdminController
{
    public function index()
    {
        $portfolios = Resource::bySequence('portfolio', PermissionService::ENV_ADMIN);

        return view('admin.portfolio.index', compact('portfolios'));
    }
}
