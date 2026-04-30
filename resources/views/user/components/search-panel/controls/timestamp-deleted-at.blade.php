@php
    $deleted_at_min = $deleted_at_min ?? request()->query('deleted_at_min');
    $deleted_at_max = $deleted_at_max ?? request()->query('deleted_at_max');
@endphp
<div class="card min-max-search-controls">
    <label>deleted at</label>
    <div>
        <div>
            <span class="min-label">from</span>
        </div>
        <div class="search-form-control">
            @include('user.components.form-input-with-icon', [
                'type'    => 'datetime-local',
                'name'    => 'deleted_at-min',
                'label'   => '',
                'value'   => $deleted_at_min,
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
                'name'    => 'deleted_at-max',
                'label'   => '',
                'value'   => $deleted_at_max,
                'message' => $message ?? '',
                'style'   => [ 'width: 10rem' ],
            ])
        </div>
    </div>
</div>
