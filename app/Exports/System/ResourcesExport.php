<?php

namespace App\Exports\System;

use App\Models\System\Resource;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResourcesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Resource()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Resource::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
