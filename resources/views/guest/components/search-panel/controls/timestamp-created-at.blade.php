@php
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');
@endphp
<div class="search-form-control">
    @include('guest.components.form-input', [
        'type'    => 'datetime-local',
        'name'    => 'created_at-min',
        'label'   => 'created from',
        'value'   => $created_at_min,
        'message' => $message ?? '',
    ])
</div>
<div class="search-form-control">
    @include('guest.components.form-input', [
        'type'    => 'datetime-local',
        'name'    => 'created_at-max',
        'label'   => 'created to',
        'value'   => $created_at_max,
        'message' => $message ?? '',
    ])
</div>
