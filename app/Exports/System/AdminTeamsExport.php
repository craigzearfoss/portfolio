<?php

namespace App\Exports\System;

use App\Models\System\AdminTeam;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminTeamsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return AdminTeam::all();
    }
}
