<?php

namespace App\Exports\System;

use App\Models\System\Session;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class SessionsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Session::all();
    }
}
