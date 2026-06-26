@php
    $event_datetime_min = $event_datetime_min ?? request()->query('event_datetime-min');
    $event_datetime_max = $event_datetime_max ?? request()->query('event_datetime-max');
@endphp
<div class="card min-max-search-controls">
    <label>datetime</label>
    <div>
        <div>
            <span class="min-label">from</span>
        </div>
        <div class="search-form-control">
            @include('guest.components.form-input-with-icon', [
                'type'    => 'date',
                'name'    => 'event_datetime-min',
                'label'   => '',
                'value'   => $event_datetime_min,
                'message' => $message ?? '',
                'class'   => [ 'submit-search-on-enter-key' ],
                'style'   => [ 'width: 10rem' ],
            ])
        </div>
    </div>
    <div>
        <div>
            <span class="max-label">to</span>
        </div>
        <div class="search-form-control">
            @include('guest.components.form-input', [
                'type'    => 'date',
                'name'    => 'event_datetime-max',
                'label'   => '',
                'value'   => $event_datetime_max,
                'message' => $message ?? '',
                'class'   => [ 'submit-search-on-enter-key' ],
                'style'   => [ 'width: 10rem' ],
            ])
        </div>
    </div>
</div>
