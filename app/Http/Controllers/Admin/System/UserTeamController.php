<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\System\StoreUserTeamsRequest;
use App\Http\Requests\System\UpdateUserTeamsRequest;
use App\Models\System\UserTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class UserTeamController extends BaseAdminController
{
}
