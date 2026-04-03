@php
    use App\Models\System\Database;

    $owner_id   = $owner->id ?? -1;
    $id         = $id ?? request()->query('id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'id',
        'label'    => 'database',
        'value'    => $id,
        'list'     => new Database()->listOptions(
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
