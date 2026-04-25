<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Publication;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class PublicationsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Publication()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Publication::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
