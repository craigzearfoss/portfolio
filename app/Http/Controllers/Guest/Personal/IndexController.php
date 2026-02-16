<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Enums\EnvTypes;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    /**
     * Display a listing of personal resources.
     * NOTE: $this->owner is set in the BaseController->initialize() method.
     *
     * @param Admin|null $admin
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Admin|null $admin, Request $request): View
    {
        if (!empty($this->owner)) {

            $databaseId = new Database()->where('tag', 'personal_db')->first()->id ?? null;

            $personals = !empty($databaseId)
                ? AdminResource::ownerResources($this->owner->id, EnvTypes::GUEST, $databaseId)
                : [];

        } else {

            $personals = [];
        }

        return view(themedTemplate('guest.personal.index'), compact('personals'));
    }
}
