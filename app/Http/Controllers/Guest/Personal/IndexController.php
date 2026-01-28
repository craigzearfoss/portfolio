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
        if (!empty($owner)) {

            if ($database = AdminDatabase::where('tag', 'personal_db')->where('owner_id', $owner->id)->first()) {
                $resources = AdminResource::ownerResources(
                    $owner->id,
                    PermissionService::ENV_GUEST,
                    $database->database_id,
                    [],
                    ['title', 'asc']
                );
            } else {
                $resources = [];
            }

        } else {

            if ($database = Database::where('tag', 'personal_db')->first()) {
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

        return view(themedTemplate('guest.personal.index'), compact('owner', 'database', 'resources'));
    }
}
