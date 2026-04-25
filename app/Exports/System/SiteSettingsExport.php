<?php

namespace App\Exports\System;

use App\Models\System\SiteSetting;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SiteSettingsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new SiteSetting()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', SiteSetting::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
