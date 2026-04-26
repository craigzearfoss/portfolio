<?php

namespace App\Exports\Career;

use App\Models\Career\Communication;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommunicationsExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Communication()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Communication::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        )->select([
            DB::raw('communications.id as id'),
            DB::raw('admins.username as owner_username'),
            DB::raw('applications.id as application_id'),
            //DB::raw('applications.post_date as application_post_date'),
            DB::raw('applications.apply_date as application_apply_date'),
            DB::raw('applications.role as application_role'),
            //DB::raw('applications.company_id as company_id'),
            DB::raw('companies.name as company_name'),
            DB::raw('communication_types.name as communication_type'),
            DB::raw('communications.subject AS subject'),
            //DB::raw('communications.body AS body'),
            DB::raw('communications.to AS `to`'),
            DB::raw('communications.from AS `from`'),
            DB::raw('communications.communication_datetime AS `datetime`'),
            DB::raw('communications.link AS link'),
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
            'application id',
            //'application_post_date',
            /*'application_apply_date'*/ 'applied',
            /*'application_role'*/ 'role',
            //'company_id',
            /*'company_name'*/ 'company',
            /*'communication_type'*/ 'type',
            'subject',
            //'body',
            'to',
            'from',
            'datetime',
            'link',
        ];
    }
}
