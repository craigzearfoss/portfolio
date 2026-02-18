<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Enums\EnvTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class IndexController extends BaseAdminController
{
    /**
     * Displays all personal resource type.
     *
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Request $request): View
    {
        $personals = [];

        if ($databaseId = new Database()->where('tag', 'personal_db')->first()->id ?? null) {

            if (isRootAdmin() || empty($this->owner)) {

                $personals = new Resource()->searchQuery([
                    'database_id'          => $databaseId,
                    EnvTypes::ADMIN->value => 1
                ])
                ->orderBy('sequence', 'asc')
                ->get();

            } else {

                $personals = new AdminResource()->searchQuery([
                    'database_id'          => $databaseId,
                    'owner_id'             => $this->owner['id'],
                    EnvTypes::ADMIN->value => 1
                ])
                ->orderBy('sequence', 'asc')
                ->get();
            }
        }

        return view('admin.personal.index', compact('personals'));
    }
}
