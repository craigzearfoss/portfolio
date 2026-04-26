<?php

namespace App\Exports\System;

use App\Models\System\ResourceSetting;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResourceSettingsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new ResourceSetting()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', ResourceSetting::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
