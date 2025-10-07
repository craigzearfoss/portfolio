<?php

namespace App\Http\Controllers\Guest\Personal;

use App\Http\Controllers\Controller;
use App\Models\Database;
use App\Models\Resource;
use App\Services\PermissionService;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        $personals = Resource::bySequence( 'personal', PermissionService::ENV_GUEST);

        return view('guest.personal.index', compact('personals'));
    }
}
