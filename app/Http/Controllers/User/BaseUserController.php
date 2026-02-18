<?php

namespace App\Http\Controllers\User;

use App\Enums\EnvTypes;
use App\Http\Controllers\BaseController;
use App\Services\PermissionService;

class BaseUserController extends BaseController
{
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct($permissionService, EnvTypes::USER);

        if (!config('app.users_enabled')) {
            abort(403, 'Users are not enabled on the site.');
        }
    }
}
