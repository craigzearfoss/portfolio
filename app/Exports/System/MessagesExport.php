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
        $query = new Message()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Message::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        );

        return $query->get();
    }
}
