<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\System\Resource;
use App\Services\PermissionService;
use Illuminate\View\View;

class IndexController extends BaseGuestController
{
    public function index(): View
    {
        $personals = Resource::bySequence( 'personal', PermissionService::ENV_GUEST);

        return view('guest.personal.index', compact('personals'));
    }
}
