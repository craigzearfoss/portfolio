<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    /**
     * Display a listing of portfolio resources.
     *
     * @param Admin|null $admin
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function index(Admin|null $admin, Request $request): View
    {
        if (!empty($admin)) {

            $database = AdminDatabase::where('tag', 'portfolio_db')->where('owner_id', $admin->id)->first();
            $resources = AdminResource::getResources(
                $admin->id,
                PermissionService::ENV_GUEST,
                $database->database_id,
                [],
                [ 'title', 'asc' ]
            );

        } else {

            $database = Database::where('tag', 'portfolio_db')->first();
            $resources = Resource::getResources(
                $admin->id,
                PermissionService::ENV_GUEST,
                $database->id,
                [],
                [ 'title', 'asc' ]
            );

        }

        return view(themedTemplate('guest.portfolio.index'), compact('database', 'resources', 'admin'));
    }
}
