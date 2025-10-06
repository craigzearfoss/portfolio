<?php

namespace App\Http\Controllers\Guest\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Database;
use App\Models\Resource;
use App\Services\PermissionService;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {

        $resources = Resource::bySequence('portfolio', PermissionService::ENV_GUEST);

        $resources = Database::getResources(config('app.portfolio_db'), [ 'public' => true, 'disabled' => false ]);

        return view('guest.portfolio', compact('resources'));
    }
}
