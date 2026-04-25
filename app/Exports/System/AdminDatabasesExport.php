<?php

namespace App\Exports\System;

use App\Models\System\AdminDatabase;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminDatabasesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return AdminDatabase::all();
    }
}
