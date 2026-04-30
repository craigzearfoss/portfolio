@php
    use App\Models\System\Admin;

    $admin_id = $admin_id ?? null;
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'admin_id',
        'label'    => 'admin',
        'value'    => $admin_id,
        'list'     => new Admin()->listOptions(
            [],
            'id',
            'username',
            true,
            false,
            [ 'username', 'asc' ]
        ),
        'style'    =>'width: 12rem',
    ])
</div>
