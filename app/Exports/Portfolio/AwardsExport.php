<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Award;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AwardsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Award()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Award::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
