<?php

namespace App\Http\Controllers\Admin\Personal;

use App\Http\Controllers\BaseController;
use App\Models\Resource;

class IndexController extends BaseController
{
    public function index()
    {
        $careerTypes = Resource::where('section', 'Career')->orderBy('sequence', 'asc') ->get();

        return view('admin.career.index', compact('careerTypes'));
    }
}
