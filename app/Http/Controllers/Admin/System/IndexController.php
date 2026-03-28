<?php

namespace App\Http\Controllers\Admin\System;

use App\Enums\EnvTypes;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Database;
use App\Models\System\AdminResource;
use App\Models\System\Resource;
use Exception;
use Illuminate\View\View;

/**
 *
 */
class IndexController extends BaseAdminController
{
    /**
     * Displays all system resource type.
     *
     * @return View
     * @throws Exception
     */
    public function index(): View
    {
        $systems = [];

        if ($databaseId = new Database()->where('tag', '=', 'system_db')->first()->id ?? null) {

            if (isRootAdmin() || empty($this->owner)) {

                $systems = new Resource()->searchQuery([
                    'database_id'          => $databaseId,
                    EnvTypes::ADMIN->value => 1
                ])
                ->orderBy('sequence')
                ->get();

            } else {

                $systems = new AdminResource()->searchQuery([
                    'database_id'          => $databaseId,
                    'owner_id'             => $this->owner['id'],
                    EnvTypes::ADMIN->value => 1
                ])
                ->orderBy('sequence')
                ->get();
            }
        }

        return view('admin.system.index', compact('systems'));
    }
}
