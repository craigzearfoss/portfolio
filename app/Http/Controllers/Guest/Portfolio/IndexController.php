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

class IndexController extends BaseGuestController
{
    /**
     * Display a listing of portfolio resources.
     *
     * @param Admin|null $admin
     * @param Request $request
     * @return View
     * @throws Exception
     */
    public function index(Admin|null $admin, Request $request): View
    {
        if (!empty($this->owner)) {

            $databaseId = new Database()->where('tag', 'portfolio_db')->first()->id ?? null;

            $portfolios = !empty($databaseId)
                ? new AdminResource()->ownerResources($this->owner->id, EnvTypes::GUEST, $databaseId)
                : [];

        } else {

            $portfolios = [];
        }

        return view(themedTemplate('guest.portfolio.index'), compact('portfolios'));
    }
}
