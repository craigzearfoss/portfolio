<?php

namespace App\Exports\System;

use App\Models\System\UserTeam;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserTeamsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new UserTeam()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', UserTeam::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
