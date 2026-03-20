<?php

namespace App\Http\Controllers\Admin\Career;

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
     * Display a listing of career resources.
     *
     * @return View
     * @throws Exception
     */
    public function index(): View
    {
        if (isRootAdmin()) {

            $careers = new Resource()->ownerResources(
                EnvTypes::ADMIN,
                'career_db'
            );

        } else {

            $careers = new AdminResource()->ownerResources(
                $this->owner,
                EnvTypes::ADMIN,
                'career_db'
            );
        }

        return view('admin.career.index', compact('careers'));
    }
}
