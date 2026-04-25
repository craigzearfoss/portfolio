<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Job;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Job()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Job::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
