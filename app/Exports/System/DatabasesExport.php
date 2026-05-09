<?php

namespace App\Exports\System;

use App\Models\System\Database;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DatabasesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Database()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Database::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
