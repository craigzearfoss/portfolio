@php
    use App\Models\System\User;

    $user_id = $user_id ?? null;
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'user_id',
        'label'    => 'user',
        'value'    => $user_id,
        'list'     => new User()->listOptions(
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
