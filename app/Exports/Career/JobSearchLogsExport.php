<?php

namespace App\Exports\Career;

use App\Models\Career\JobSearchLog;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobSearchLogsExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new JobSearchLog()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobSearchLog::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
