<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Controller;
use App\Models\Dictionary\DictionarySection;
use App\Models\Resource;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected $perPage = 30;
    public function index(Request $request)
    {
        $perPage= $request->query('per_page', $this->perPage);

        $words = DictionarySection::wordCollection(null, $perPage);

        $dictionaryTypes = Resource::where('section', 'Dictionary')->orderBy('sequence', 'asc')->get();

        return view('admin.dictionary.index', compact('words'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);

        return view('admin.dictionary.index', compact('words', 'dictionaryTypes'));

    }
}
