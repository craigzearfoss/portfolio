<?php

namespace App\Exports\Career;

use App\Models\Career\Industry;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class IndustriesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Industry()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Industry::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
