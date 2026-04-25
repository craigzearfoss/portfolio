<?php

namespace App\Exports\System;

use App\Models\System\AdminPhone;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminPhonesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        $query = new AdminPhone()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', AdminPhone::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
