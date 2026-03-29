@php
    use App\Models\System\AdminDatabase;

    $owner_id    = $owner_id ?? request()->query('owner_id');
    $database_id = $database_id ?? request()->query('database_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'database_id',
        'label'    => 'database',
        'value'    => $database_id,
        'list'     => new AdminDatabase()->listOptions(
                          [ 'owner_id' => $owner_id ],
                          'id',
                          'tag',
                          true,
                          false,
                          [ 'tag', 'asc' ]
                      ),
        'style'    => 'width: 8rem;'
    ])
</div>
