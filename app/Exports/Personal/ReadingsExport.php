<?php

namespace App\Exports\Personal;

use App\Models\Personal\Reading;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReadingsExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Reading()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Reading::SEARCH_ORDER_BY),
            config('app.single_admin_mode') || isRootAdmin() ? loggedInAdmin() : null
        )->select([
            DB::raw('readings.id as id'),
            DB::raw('admins.username as owner_username'),
            DB::raw('readings.title as title'),
            DB::raw('readings.author as author'),
            DB::raw('readings.featured as featured'),
            DB::raw('readings.fiction as fiction'),
            DB::raw('readings.nonfiction as nonfiction'),
            DB::raw('readings.paper as paper'),
            DB::raw('readings.audio as audio'),
            DB::raw('readings.wishlist as wishlist'),
            DB::raw('readings.link as link'),
        ]);

        return $query->get();
    }

    /**
     * Column headings for the exported Excel spreadsheet.
     *
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'id',
            /*'owner_username'*/ 'owner',
            'title',
            'author',
            'featured',
            'fiction',
            'nonfiction',
            'paper',
            'audio',
            'wishlist',
            'link',
        ];
    }
}
