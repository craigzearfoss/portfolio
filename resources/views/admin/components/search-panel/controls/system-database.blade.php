@php
    use App\Models\System\Database;

    $owner_id   = $owner_id ?? request()->query('owner_id');
    $isRootAmin = $isRootAmin ?? false;
    $id         = $id ?? request()->query('id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'id',
        'label'    => 'database',
        'value'    => $id,
        'list'     => new Database()->listOptions(
                          $isRootAmin ? [] : [ 'owner_id' => $owner_id ],
                          'id',
                          'tag',
                          true,
                          false,
                          [ 'tag', 'asc' ]
                      ),
        'style'    => 'width: 8rem;'
    ])
</div>
