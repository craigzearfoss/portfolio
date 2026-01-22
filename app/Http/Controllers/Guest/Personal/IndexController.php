<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
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
     * @param Admin|null $admin
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function index(Admin|null $admin, Request $request): View
    {
        $owner = $admin;

        if (!empty($owner)) {

            $database = AdminDatabase::where('tag', 'personal_db')->where('owner_id', $owner->id)->first();
            $resources = AdminResource::ownerResources(
                $owner->id,
                PermissionService::ENV_GUEST,
                $database->database_id,
                [],
                [ 'title', 'asc' ]
            );

        } else {

            $database = Database::where('tag', 'personal_db')->first();
            $resources = Resource::ownerResources(
                $owner->id,
                PermissionService::ENV_GUEST,
                $database->id,
                [],
                [ 'title', 'asc' ]
            );

        }

        return view(themedTemplate('guest.personal.index'), compact('owner', 'database', 'resources'));
    }
}
