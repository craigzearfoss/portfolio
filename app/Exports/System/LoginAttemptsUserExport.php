<?php

namespace App\Exports\System;

use App\Models\System\LoginAttemptsUser;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class LoginAttemptsUserExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return LoginAttemptsUser::all();
    }
}
