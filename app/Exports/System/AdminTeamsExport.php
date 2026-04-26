<?php

namespace App\Exports\System;

use App\Models\System\AdminTeam;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminTeamsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new AdminTeam()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', AdminTeam::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
