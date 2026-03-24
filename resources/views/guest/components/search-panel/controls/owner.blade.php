@php
    use App\Models\System\Admin;

    $owner_id = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'owner_id',
        'label'    => 'owner',
        'value'    => $owner_id,
        'list'     => new Admin()->listOptions([], 'id', 'username', 0, false, [ 'username', 'asc' ]),
        'onchange' => "document.getElementById('searchForm').submit()"
    ])
</div>
