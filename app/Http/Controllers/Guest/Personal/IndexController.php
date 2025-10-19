<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Admin;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    /**
     * Display a listing of personal resources.
     *
     * @param Admin $admin
     * @return View
     * @throws \Exception
     */
    public function index(Admin $admin): View
    {
        $personals = Resource::bySequence( 'personal', PermissionService::ENV_GUEST);

        return view(themedTemplate('guest.personal.index'), compact('personals', 'admin'));
    }
}
