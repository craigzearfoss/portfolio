@php
    $status = intval($status ?? request()->query('status'));
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'status',
        'value'    => $status > 1 ? 2 : $status,
        'list'     => [ 2 => 'active', 1 => 'inactive', 0 => 'all' ],
        'style'    => 'width: 6rem;',
    ])
</div>
