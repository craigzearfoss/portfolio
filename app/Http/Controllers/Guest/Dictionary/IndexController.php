<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\DictionarySection;
use App\Models\System\Resource;
use Illuminate\Http\Request;

class IndexController extends BaseGuestController
{
    protected $PAGINATION_PER_PAGE = 30;

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', $this->perPage());

        $words = DictionarySection::words(null, $perPage);

        $dictionaryTypes = Resource::select('resources.*')
            ->where('databases.name', 'dictionary')
            ->join('databases', 'databases.id', '=', 'resources.database_id')
            ->orderBy('resources.plural')
            ->get();

        return view(themedTemplate('guest.dictionary.index'), compact('words'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }
}
