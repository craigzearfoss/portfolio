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
        if (!empty($this->owner)) {

            if ($database = AdminDatabase::where('tag', 'portfolio_db')->where('owner_id', $this->owner->id)->first()) {
                $resources = AdminResource::ownerResources(
                    $this->owner->id,
                    PermissionService::ENV_GUEST,
                    $database->database_id,
                    [],
                    ['title', 'asc']
                );
            } else {
                $resources = [];
            }

        } else {

            if ($database = Database::where('tag', 'portfolio_db')->first()) {
                $resources = Resource::ownerResources(
                    null,
                    PermissionService::ENV_GUEST,
                    $database->id,
                    [],
                    ['title', 'asc']
                );
            } else {
                $resources = [];
            }
        }

        return view(themedTemplate('guest.portfolio.index'), compact('owner', 'database', 'resources'));
    }
}
