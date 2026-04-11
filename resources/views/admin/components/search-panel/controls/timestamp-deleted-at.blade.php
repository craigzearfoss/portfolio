@php
    $deleted_at_from = $deleted_at_from ?? request()->query('deleted_at_from');
    $deleted_at_to   = $deleted_at_to ?? request()->query('deleted_at_to');
@endphp
<div class="search-form-control">
    @include('admin.components.form-input-with-icon', [
        'type'    => 'datetime-local',
        'name'    => 'deleted_at_from',
        'label'   => 'deleted from',
        'value'   => $deleted_at_from,
        'message' => $message ?? '',
    ])
</div>
<div class="search-form-control">
    @include('admin.components.form-input', [
        'type'    => 'datetime-local',
        'name'    => 'deleted_at_to',
        'label'   => 'deleted to',
        'value'   => $deleted_at_to,
        'message' => $message ?? '',
    ])
</div>
