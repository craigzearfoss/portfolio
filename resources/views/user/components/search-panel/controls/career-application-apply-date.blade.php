@php
    $apply_date_min = $apply_date_min ?? request()->query('apply_date-min');
    $apply_date_max = $apply_date_max ?? request()->query('apply_date-max');
@endphp
<div class="card min-max-search-controls">
    <label>applied</label>
    <div>
        <div>
            <span class="min-label">from</span>
        </div>
        <div class="search-form-control">
            @include('user.components.form-input-with-icon', [
                'type'    => 'date',
                'name'    => 'apply_date-min',
                'label'   => '',
                'value'   => $apply_date_min,
                'message' => $message ?? '',
                'style'   => [ 'width: 6rem' ],
            ])
        </div>
    </div>
    <div>
        <div>
            <span class="max-label">to</span>
        </div>
        <div class="search-form-control">
            @include('user.components.form-input', [
                'type'    => 'date',
                'name'    => 'apply_date-max',
                'label'   => '',
                'value'   => $apply_date_max,
                'message' => $message ?? '',
                'style'   => [ 'width: 6rem' ],
            ])
        </div>
    </div>
</div>
