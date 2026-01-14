<?php

namespace App\Http\Controllers\Admin\Root\System;

use App\Http\Controllers\Admin\Root\BaseAdminRootController;
use App\Http\Controllers\Controller;
use App\Models\System\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SessionController extends BaseAdminRootController
{
    /**
     * Display a listing of sessions.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', $this->perPage);

        $sessions = Session::orderBy('last_activity', 'desc')->paginate($perPage);

        return view('admin.system.session.index', compact('sessions'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }

    /**
     * Display the specified session.
     *
     * @param Session $session
     * @return View
     */
    public function show(Session $session): View
    {
        return view('admin.system.session.show', compact('session'));
    }
}
