<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Education;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class EducationsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Education()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Education::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
