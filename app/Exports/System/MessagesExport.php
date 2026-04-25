<?php

namespace App\Exports\System;

use App\Models\System\Message;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class MessagesExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return Message::all();
    }
}
