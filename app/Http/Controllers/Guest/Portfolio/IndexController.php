<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Admin;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    /**
     * Display a listing of portfolio resources.
     *
     * @return View
     * @throws \Exception
     */
    public function index(): View
    {
        $portfolios = Resource::bySequence('portfolio', PermissionService::ENV_GUEST);

        return view(themedTemplate('guest.portfolio.index'), compact('portfolios'));
    }

    /**
     * @param Admin $admin
     * @param Request $request
     * @return View
     */
    public function show(Admin $admin, Request $request): View
    {die('show');
        return view('guest.portfolio.show', compact('admin'));
    }
}
