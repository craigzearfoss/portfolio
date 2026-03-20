@php
    use App\Models\System\AdminDatabase;

    $owner_id          = $owner_id ?? request()->query('owner_id');
    $admin_database_id = $admin_database_id ?? request()->query('admin_database_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'admin_database_id',
        'label'    => 'database',
        'value'    => $admin_database_id,
        'list'     => new AdminDatabase()->listOptions(
                          [ 'owner_id' => $owner_id ],
                          'id',
                          'tag',
                          0,
                          false,
                          [ 'tag', 'asc' ]
                      ),
        'onchange' => "document.getElementById('searchForm').submit()"
    ])
</div>
