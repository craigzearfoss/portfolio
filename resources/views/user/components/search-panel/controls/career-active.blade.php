@php
    $active   = $active ?? request()->query('active');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'     => 'active',
        'label'    => 'status',
        'value'    => $active,
        'list'     => [ 1 => 'active', 0 => 'inactive', 3 => 'all' ],
        'style'    => 'min-width: 6rem;',
    ])
</div>
