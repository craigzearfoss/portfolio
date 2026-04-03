@php
    use App\Models\System\Admin;

    $owner_id = $owner->id ?? -1;
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'owner_id',
        'label'    => 'owner',
        'value'    => $owner_id,
        'list'     => new Admin()->listOptions(
            [],
            'id',
            'username',
            true,
            false,
            [ 'username', 'asc' ]
        )
    ])
</div>
