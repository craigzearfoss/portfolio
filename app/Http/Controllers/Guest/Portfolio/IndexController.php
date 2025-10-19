<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Admin;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    /**
     * Display a listing of portfolio resources.
     *
     * @param Admin $admin
     * @return View
     * @throws \Exception
     */
    public function index(Admin $admin): View
    {
        $portfolios = Resource::bySequence('portfolio', PermissionService::ENV_GUEST);

        return view(themedTemplate('guest.portfolio.index'), compact('portfolios', 'admin'));
    }
}
