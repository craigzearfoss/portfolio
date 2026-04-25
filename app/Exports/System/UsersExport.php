<?php

namespace App\Exports\System;

use App\Models\System\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return User::all();
    }
}
