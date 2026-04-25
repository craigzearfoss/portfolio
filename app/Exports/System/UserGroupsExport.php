<?php

namespace App\Exports\System;

use App\Models\System\UserGroup;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserGroupsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return UserGroup::all();
    }
}
