@php
    $closed_from = $closed_from ?? request()->query('closed_from');
    $closed_to   = $closed_to ?? request()->query('closed_to');
@endphp
<div class="search-form-control">
    @include('admin.components.form-input-with-icon', [
        'type'     => 'date',
        'name'     => 'closed_from',
        'label'    => 'closed from',
        'value'    => $closed_from,
        'nohidden' => true,
    ])
</div>
<div class="search-form-control">
    @include('admin.components.form-input', [
        'type'     => 'date',
        'name'     => 'closed_to',
        'label'    => 'closed to',
        'value'    => $closed_to,
        'nohidden' => true,
    ])
</div>
