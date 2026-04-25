<?php

namespace App\Exports\Career;

use App\Models\Career\Reference;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReferencesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Reference()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Reference::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
