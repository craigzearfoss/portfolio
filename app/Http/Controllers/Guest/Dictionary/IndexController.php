<?php

namespace App\Http\Controllers\Guest\Dictionary;

use App\Http\Controllers\Guest\BaseGuestController;
use App\Models\Dictionary\DictionarySection;
use App\Models\System\Resource;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexController extends BaseGuestController
{
    /**
     * @param Request $request
     * @return Factory|View|\Illuminate\View\View
     */
    public function index(Request $request): Factory|View|\Illuminate\View\View
    {
        $perPage = $request->query('per_page', $this->perPage());

        $words = DictionarySection::words(null, $perPage);

        $dictionaryTypes = new Resource()->select('resources.*')
            ->where('databases.name', 'dictionary')
            ->join('databases', 'databases.id', '=', 'resources.database_id')
            ->orderBy('resources.plural')
            ->get();

        return view(themedTemplate('guest.dictionary.index'), compact('words'))
            ->with('i', (request()->input('page', 1) - 1) * $perPage);
    }
}
