<?php

namespace App\Http\Controllers;

use App\Services\MenuService;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }
}
