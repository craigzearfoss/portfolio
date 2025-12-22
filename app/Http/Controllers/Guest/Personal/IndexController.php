<?php

namespace App\Http\Controllers\Guest\Personal;

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
     * Display a listing of personal resources.
     *
     * @param Admin $admin
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function index(Admin $admin, Request $request): View
    {
        $personalResourceTypes = Database::getAdminResourceTypes(
            $admin->id,
            'personal',
            [
                'public'   => true,
                'disabled' => false,
            ]
        );

        return view(themedTemplate('guest.personal.index'), compact('personalResourceTypes', 'admin'));
    }
}
