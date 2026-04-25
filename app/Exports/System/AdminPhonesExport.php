<?php

namespace App\Exports\System;

use App\Models\System\AdminPhone;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdminPhonesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return AdminPhone::all();
    }
}
