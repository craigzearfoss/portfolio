<?php

namespace App\Exports\Career;

use App\Models\Career\Industry;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IndustriesExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Industry()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Industry::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        )->select([
            DB::raw('industries.id as id'),
            DB::raw('industries.name as name'),
            DB::raw('industries.abbreviation as abbreviation'),
        ]);

        return $query->get();
    }

    /**
     * Column headings for the exported Excel spreadsheet.
     *
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'id',
            'name',
            'abbreviation',
        ];
    }
}
