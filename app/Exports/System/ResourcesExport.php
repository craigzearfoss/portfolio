<?php

namespace App\Exports\System;

use App\Models\System\Resource;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResourcesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new Resource()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Resource::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
