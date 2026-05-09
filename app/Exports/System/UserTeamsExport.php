<?php

namespace App\Exports\System;

use App\Models\System\UserTeam;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserTeamsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new UserTeam()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', UserTeam::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
