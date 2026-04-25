<?php

namespace App\Exports\System;

use App\Models\System\UserEmail;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserEmailsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return UserEmail::all();
    }
}
