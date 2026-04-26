<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Link;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class LinksExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Link()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Link::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
