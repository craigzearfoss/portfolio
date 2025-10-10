<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Dictionary\DictionarySection;
use App\Models\Resource;
use Illuminate\Http\Request;

class IndexController extends BaseAdminController
{
    protected $perPage = 30;
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', $this->perPage);

        $words = DictionarySection::words(null, $perPage);

        $dictionaryTypes = Resource::select('resources.*')
            ->where('databases.name', 'dictionary')
            ->join('databases', 'databases.id', '=', 'resources.database_id')
            ->orderBy('resources.plural', 'asc')
            ->get();

        return view('admin.dictionary.index', compact('words'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }
}
