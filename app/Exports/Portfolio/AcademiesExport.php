<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Academy;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AcademiesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Academy()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Academy::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
