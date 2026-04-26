<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Music;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class MusicsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Music()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Music::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
