<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Resource;

class IndexController extends Controller
{
    public function index()
    {
        $portfolioTypes = Resource::where('section', 'Portfolio')->orderBy('sequence', 'asc') ->get();

        return view('admin.portfolio.index', compact('portfolioTypes'));
    }
}
