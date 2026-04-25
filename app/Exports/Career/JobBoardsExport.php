<?php

namespace App\Exports\Career;

use App\Models\Career\JobBoard;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobBoardsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return JobBoard::all();
    }
}
