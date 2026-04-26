<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\School;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SchoolsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new School()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', School::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
