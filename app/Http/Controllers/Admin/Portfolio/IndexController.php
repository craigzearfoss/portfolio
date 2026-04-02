<?php

namespace App\Http\Controllers\Admin\Portfolio;

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
     * Display a listing of portfolio resources.
     *
     * @return View
     * @throws Exception
     */
    public function index(): View
    {
        if (isRootAdmin() || empty($this->owner)) {

             $portfolios = new Resource()->ownerResources(
                EnvTypes::ADMIN,
                'portfolio_db',
            );

        } else {

            $portfolios = new AdminResource()->ownerResources(
                $this->owner,
                EnvTypes::ADMIN,
                'portfolio_db'
             );
        }

        return view('admin.portfolio.index', compact('portfolios'));
    }
}
