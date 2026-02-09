<?php

namespace App\Http\Controllers\User;

use App\Enums\EnvTypes;
use App\Http\Controllers\BaseController;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class BaseUserController extends BaseController
{
    const OWNER_ID_COOKIE = 'user_owner_id';
    const USER_ID_COOKIE = 'user_user_id';

    public function __construct(PermissionService $permissionService, Request $request)
    {
        parent::__construct($permissionService);

        $this->initialize(EnvTypes::USER);

        if (isset($_GET['debug'])) {
            $this->ddDebug();
        }

        if (!config('app.users_enabled')) {
            abort(403, 'Users are not enabled on the site.');
        }
    }
}
