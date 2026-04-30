@php
    $updated_at_min = $updated_at_min ?? request()->query('updated_at_min');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at_max');
@endphp
<div class="card min-max-search-controls">
    <label>updated at</label>
    <div>
        <div>
            <span class="min-label">from</span>
        </div>
        <div class="search-form-control">
            @include('admin.components.form-input-with-icon', [
                'type'    => 'datetime-local',
                'name'    => 'updated_at-min',
                'label'   => '',
                'value'   => $updated_at_min,
                'message' => $message ?? '',
                'style'   => [ 'width: 10rem' ],
            ])
        </div>
    </div>
    <div>
        <div>
            <span class="max-label">to</span>
        </div>
        <div class="search-form-control">
            @include('admin.components.form-input', [
                'type'    => 'datetime-local',
                'name'    => 'updated_at-max',
                'label'   => '',
                'value'   => $updated_at_max,
                'message' => $message ?? '',
                'style'   => [ 'width: 10rem' ],
            ])
        </div>
    </div>
</div>
