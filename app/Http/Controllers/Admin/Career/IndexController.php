<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.career.index');
    }
}
