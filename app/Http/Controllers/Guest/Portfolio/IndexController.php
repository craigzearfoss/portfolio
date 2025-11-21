<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Admin;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    /**
     * Display a listing of portfolio resources.
     *
     * @param Admin $admin
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function index(Admin $admin, Request $request): View
    {
        $portfolioResources = Database::getResources('portfolio', [], ['name', 'asc']);

        return view(themedTemplate('guest.portfolio.index'), compact('portfolioResources', 'admin'));
    }
}
