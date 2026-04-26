<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\JobTask;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobTasksExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new JobTask()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobTask::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
