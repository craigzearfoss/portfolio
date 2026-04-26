<?php

namespace App\Exports\Career;

use App\Models\Career\JobBoard;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobBoardsExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new JobBoard()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', JobBoard::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        )->select([
            DB::raw('job_boards.id as id'),
            DB::raw('job_boards.name as name'),
            DB::raw('job_boards.primary as primary'),
            DB::raw('job_boards.local as local'),
            DB::raw('job_boards.regional as regional'),
            DB::raw('job_boards.national as national'),
            DB::raw('job_boards.international as international'),
            DB::raw('job_boards.link as link'),
        ]);
$query->ddRawSql();
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
            'primary',
            'local',
            'regional',
            'national',
            'international',
            'link',
        ];
    }
}
