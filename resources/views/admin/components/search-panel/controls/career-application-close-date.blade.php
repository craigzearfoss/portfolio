@php
    $close_date_min = $close_date_min ?? request()->query('close_date-min');
    $close_date_max = $close_date_max ?? request()->query('close_date-max');
@endphp
<div class="card min-max-search-controls">
    <label>closed</label>
    <div>
        <div>
            <span class="min-label">from</span>
        </div>
        <div class="search-form-control">
            @include('admin.components.form-input-with-icon', [
                'type'    => 'date',
                'name'    => 'close_date-min',
                'label'   => '',
                'value'   => $close_date_min,
                'message' => $message ?? '',
                'class'   => [ 'submit-search-on-enter-key' ],
                'style'   => [ 'width: 6rem' ],
            ])
        </div>
    </div>
    <div>
        <div>
            <span class="max-label">to</span>
        </div>
        <div class="search-form-control">
            @include('admin.components.form-input', [
                'type'    => 'date',
                'name'    => 'close_date-max',
                'label'   => '',
                'value'   => $close_date_max,
                'message' => $message ?? '',
                'class'   => [ 'submit-search-on-enter-key' ],
                'style'   => [ 'width: 6rem' ],
            ])
        </div>
    </div>
</div>
