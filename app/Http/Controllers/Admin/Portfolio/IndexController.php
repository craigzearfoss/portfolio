<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.portfolio.index');
    }
}
