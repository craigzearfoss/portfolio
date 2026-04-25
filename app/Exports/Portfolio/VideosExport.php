<?php

namespace App\Exports\Portfolio;

use App\Models\Portfolio\Video;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class VideosExport implements FromCollection
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Video()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Video::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
