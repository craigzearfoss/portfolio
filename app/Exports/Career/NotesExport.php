<?php

namespace App\Exports\Career;

use App\Models\Career\Note;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NotesExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     * @throws Exception
     */
    public function collection(): Collection
    {
        $query = new Note()->searchQuery(
            request()->except('id', 'sort'),
            request()->input('sort') ?? implode('|', Note::SEARCH_ORDER_BY),
            !isRootAdmin() ? loggedInAdmin() : null
        )->select([
            DB::raw('notes.id as id'),
            DB::raw('admins.username as owner_username'),
            DB::raw('applications.id as application_id'),
            //DB::raw('applications.post_date as application_post_date'),
            DB::raw('applications.apply_date as application_apply_date'),
            DB::raw('applications.role as application_role'),
            //DB::raw('applications.company_id as company_id'),
            DB::raw('companies.name as company_name'),
            DB::raw('notes.subject as subject'),
            DB::raw('notes.body AS body'),
            DB::raw('notes.created_at AS created_at'),
            DB::raw('events.link AS link'),
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
            'subject',
            'body',
            'created at',
            'link',
        ];
    }
}
