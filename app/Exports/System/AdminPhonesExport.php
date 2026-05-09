<?php

namespace App\Exports\System;

use App\Models\System\AdminPhone;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminPhonesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new AdminPhone()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', AdminPhone::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
