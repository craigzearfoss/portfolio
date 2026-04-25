<?php

namespace App\Exports\System;

use App\Models\System\AdminGroup;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminGroupsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return AdminGroup::all();
    }
}
