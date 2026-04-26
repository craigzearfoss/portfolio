<?php

namespace App\Exports\System;

use App\Models\System\Database;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DatabasesExport implements FromCollection
{
    /**
    * @return Collection
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
