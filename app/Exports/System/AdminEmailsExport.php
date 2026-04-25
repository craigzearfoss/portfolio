<?php

namespace App\Exports\System;

use App\Models\System\AdminEmail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminEmailsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return AdminEmail::all();
    }
}
