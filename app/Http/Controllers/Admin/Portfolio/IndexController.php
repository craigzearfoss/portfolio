<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Models\Resource;
use App\Services\PermissionService;

class IndexController extends BaseController
{
    public function index()
    {
        $portfolios = Resource::bySequence('portfolio', PermissionService::ENV_ADMIN);

        return view('admin.portfolio.index', compact('portfolios'));
    }
}
