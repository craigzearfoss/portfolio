<?php

namespace App\Exports\Career;

use App\Models\Career\Application;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ApplicationsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Application()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Application::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
