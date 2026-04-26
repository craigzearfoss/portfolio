<?php

namespace App\Exports\System;

use App\Models\System\AdminGroup;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminGroupsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new AdminGroup()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', AdminGroup::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
