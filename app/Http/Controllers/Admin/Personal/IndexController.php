<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Enums\EnvTypes;
use App\Http\Controllers\Admin\BaseAdminController;
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
     * Display a listing of personal resources.
     *
     * @return View
     * @throws Exception
     */
    public function index(): View
    {
        if (isRootAdmin()) {

            $personals = new Resource()->ownerResources(
                EnvTypes::ADMIN,
                'personal_db'
            );

        } else {

            $personals = new AdminResource()->ownerResources(
                $this->owner,
                EnvTypes::ADMIN,
                'personal_db'
            );
        }

        return view('admin.personal.index', compact('personals'));
    }
}
