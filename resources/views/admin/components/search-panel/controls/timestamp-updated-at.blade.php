@php
    $updated_at_from = $updated_at_from ?? request()->query('updated_at_from');
    $updated_at_to   = $updated_at_to ?? request()->query('updated_at_to');
@endphp
<div class="search-form-control">
    @include('admin.components.form-input-with-icon', [
        'type'    => 'datetime-local',
        'name'    => 'updated_at_from',
        'label'   => 'updated from',
        'value'   => $updated_at_from,
        'message' => $message ?? '',
    ])
</div>
<div class="search-form-control">
    @include('admin.components.form-input', [
        'type'    => 'datetime-local',
        'name'    => 'updated_at_to',
        'label'   => 'updated to',
        'value'   => $updated_at_to,
        'message' => $message ?? '',
    ])
</div>
