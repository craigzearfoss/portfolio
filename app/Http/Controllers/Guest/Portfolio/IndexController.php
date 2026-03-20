<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Enums\EnvTypes;
use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Admin;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class IndexController extends BaseGuestController
{
    /**
     * Display a listing of portfolio resources.
     *
     * @return View
     * @throws Exception
     */
    public function index(): View
    {
        if (!empty($this->owner)) {

            $portfolios = new AdminResource()->ownerResources(
                $this->owner,
                EnvTypes::GUEST,
                'portfolio_db',
                [ 'menu' => true, 'is_public' => true, 'is_disabled' =>false ]
            );

        } else {

            $portfolios = [];
        }

        return view(themedTemplate('guest.portfolio.index'), compact('portfolios'));
    }
}
