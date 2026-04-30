@php
    $created_at_min = $created_at_min ?? request()->query('created_at_min');
    $created_at_max = $created_at_max ?? request()->query('created_at_max');
@endphp
<div class="card min-max-search-controls">
    <label>created at</label>
    <div>
        <div>
            <span class="min-label">from</span>
        </div>
        <div class="search-form-control">
            @include('user.components.form-input-with-icon', [
                'type'    => 'datetime-local',
                'name'    => 'created_at-min',
                'label'   => '',
                'value'   => $created_at_min,
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
            @include('user.components.form-input', [
                'type'    => 'datetime-local',
                'name'    => 'created_at-max',
                'label'   => '',
                'value'   => $created_at_max,
                'message' => $message ?? '',
                'style'   => [ 'width: 10rem' ],
            ])
        </div>
    </div>
</div>
