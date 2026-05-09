<?php

namespace App\Exports\System;

use App\Models\System\UserPhone;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserPhonesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new UserPhone()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', UserPhone::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
