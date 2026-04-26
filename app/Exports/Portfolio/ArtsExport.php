<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Art;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArtsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Art()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Art::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
