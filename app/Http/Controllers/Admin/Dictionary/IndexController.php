<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Models\Resource;

class IndexController extends Controller
{
    public function index()
    {
        $dictionaryTypes = Resource::where('section', 'Dictionary')->orderBy('sequence', 'asc') ->get();

        return view('admin.dictionary.index', compact('dictionaryTypes'));
    }
}
