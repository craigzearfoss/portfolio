<?php

namespace App\Exports\System;

use App\Models\System\UserPhone;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserPhonesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return UserPhone::all();
    }
}
