<?php

namespace App\Exports\System;

use App\Models\System\UserTeam;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserTeamsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return UserTeam::all();
    }
}
