<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    public function index(): View
    {
        $portfolios = Resource::bySequence('portfolio', PermissionService::ENV_GUEST);

        return view(themedTemplate('guest.portfolio.index'), compact('portfolios'));
    }
}
