<?php

namespace App\Exports\Career;

use App\Models\Career\Resume;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResumesExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Resume()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Resume::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
