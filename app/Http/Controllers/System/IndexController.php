<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\System\BaseSystemController;

use Illuminate\View\View;

/**
 *
 */
class IndexController extends BaseSystemController
{
    /**
     * Displays all system resource type.
     *
     * @return View
     */
    public function index(): View
    {
        $menuItems= [
            [
                'name' => 'Environment',
                'href' => route('system.environment.index'),
            ],
            [
                'name' => 'Backup',
                'href' => route('system.backup.index'),
            ],
        ];

        return view('system.index', compact('menuItems'));
    }
}
