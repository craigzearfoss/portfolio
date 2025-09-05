<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\BaseController;
use App\Models\Resource;

class IndexController extends BaseController
{
    public function index()
    {
        $portfolioTypes = Resource::where('section', 'Portfolio')->orderBy('sequence', 'asc') ->get();

        return view('admin.portfolio.index', compact('portfolioTypes'));
    }
}
