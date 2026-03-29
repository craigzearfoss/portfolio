@php
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
@endphp
<div class="search-form-control">
    @include('guest.components.input-basic', [
        'type'    => 'datetime-local',
        'name'    => 'created_at_from',
        'label'   => 'created from',
        'value'   => $created_at_from,
        'message' => $message ?? '',
    ])
</div>
<div class="search-form-control">
    @include('guest.components.input-basic', [
        'type'    => 'datetime-local',
        'name'    => 'created_at_to',
        'label'   => 'created to',
        'value'   => $created_at_to,
        'message' => $message ?? '',
    ])
</div>
