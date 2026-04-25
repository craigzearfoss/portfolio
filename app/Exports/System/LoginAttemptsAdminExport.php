<?php

namespace App\Exports\System;

use App\Models\System\LoginAttemptsAdmin;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class LoginAttemptsAdminExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return LoginAttemptsAdmin::all();
    }
}
