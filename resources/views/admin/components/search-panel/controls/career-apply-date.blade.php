@php
    $apply_from = $apply_from ?? request()->query('apply_from');
    $apply_to   = $apply_to ?? request()->query('apply_to');
@endphp
<div class="search-form-control">
    @include('admin.components.input-basic', [
        'type'     => 'date',
        'name'     => 'apply_from',
        'label'    => 'applied from',
        'value'    => $apply_from,
        'nohidden' => true,
    ])
</div>
<div class="search-form-control">
    @include('admin.components.input-basic', [
        'type'     => 'date',
        'name'     => 'apply_to',
        'label'    => 'applied to',
        'value'    => $apply_to,
        'nohidden' => true,
    ])
</div>
