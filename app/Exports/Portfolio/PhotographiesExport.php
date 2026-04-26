<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Photography;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class PhotographiesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Photography()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Photography::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
