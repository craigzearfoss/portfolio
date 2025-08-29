<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Models\Resource;

class IndexController extends Controller
{
    public function index()
    {
        $careerTypes = Resource::where('section', 'Career')->orderBy('sequence', 'asc') ->get();

        return view('admin.career.index', compact('careerTypes'));
    }
}
