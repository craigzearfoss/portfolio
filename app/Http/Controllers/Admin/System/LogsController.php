<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\System\Database;
use App\Models\System\LoginAttemptsAdmin;
use App\Models\System\LoginAttemptsUser;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogsController extends BaseAdminController
{
    /**
     * Display a listing of databases.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $type = $request->query('type', 'admin');
        if (!in_array($type, ['admin', 'user'])) {
            $type = 'admin';
        }

        if ($type == 'admin') {
            //$loginAttempts = LoginAttemptsAdmin::orderBy('created_at', 'desc')->paginate($perPage);
            $loginAttempts = LoginAttemptsAdmin::searchBuilder($request->all(), ['created_at', 'desc'])->paginate($perPage)
                ->appends(request()->except('page'));;
        } else {
            //$loginAttempts = LoginAttemptsUserAdmin::orderBy('created_at', 'desc')->paginate($perPage);
            $loginAttempts = LoginAttemptsUser::searchBuilder($request->all(), ['created_at', 'desc'])->paginate($perPage)
                ->appends(request()->except('page'));;
        }

        return view('admin.system.log.index', compact('type', 'loginAttempts'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }
}
