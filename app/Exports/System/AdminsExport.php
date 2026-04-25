<?php

namespace App\Exports\System;

use App\Models\System\Admin;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Admin::all();
    }
}
