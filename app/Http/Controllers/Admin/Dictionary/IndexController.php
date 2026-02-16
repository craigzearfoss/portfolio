<?php

namespace App\Http\Controllers\Admin\Dictionary;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Dictionary\DictionarySection;
use App\Models\System\Resource;
use Illuminate\Http\Request;

/**
 *
 */
class IndexController extends BaseAdminController
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 30 /*$this->perPage()*/);

        $words = DictionarySection::words(null, $perPage);

        $dictionaryTypes = new Resource()->select('resources.*')
            ->where('databases.name', 'dictionary')
            ->join('databases', 'databases.id', '=', 'resources.database_id')
            ->orderBy('resources.plural')
            ->get();

        return view('admin.dictionary.index', compact('words'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }
}
