<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Project;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Project()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Project::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
