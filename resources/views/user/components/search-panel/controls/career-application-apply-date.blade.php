@php
    $applied_from = $applied_from ?? request()->query('applied_from');
    $applied_to   = $applied_to ?? request()->query('applied_to');
@endphp
<div class="search-form-control">
    @include('user.components.input', [
        'type'     => 'date',
        'name'     => 'applied_from',
        'label'    => 'applied from',
        'value'    => $applied_from,
        'nohidden' => true,
    ])
</div>
<div class="search-form-control">
    @include('user.components.input', [
        'type'     => 'date',
        'name'     => 'applied_to',
        'label'    => 'applied to',
        'value'    => $applied_to,
        'nohidden' => true,
    ])
</div>
