<?php

namespace App\Exports\System;

use App\Models\System\AdminResource;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminResourcesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new AdminResource()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', AdminResource::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
