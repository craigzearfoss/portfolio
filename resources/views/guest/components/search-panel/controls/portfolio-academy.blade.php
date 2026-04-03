@php
    use App\Models\Portfolio\Academy;

    $owner_id   = $owner_id ?? request()->query('owner_id');
    $isRootAmin = $isRootAmin ?? false;
    $academy_id = $academy_id ?? request()->query('academy_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'academy_id',
        'label'    => 'academy',
        'value'    => $academy_id,
        'list'     => new Academy()->listOptions(
                          [],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'asc' ]
                      ),
        'style'    => 'min-width: 6rem;'
    ])
</div>
