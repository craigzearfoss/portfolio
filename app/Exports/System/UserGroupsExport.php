<?php

namespace App\Exports\System;

use App\Models\System\UserGroup;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserGroupsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new UserGroup()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', UserGroup::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
