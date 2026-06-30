@php
    $event_datetime_min = $event_datetime_min ?? request()->query('event_datetime-min');
    $event_datetime_max = $event_datetime_max ?? request()->query('event_datetime-max');
@endphp
<div class="card search-control-group">
    <table>
        <tr>
            <th colspan="2" class="has-text-centered">created at</th>
        </tr>
        <tr>
            <th><span class="pr-1">from</span></th>
            <td>
                @include('user.components.form-input', [
                    'type'    => 'datetime-local',
                    'name'    => 'event_datetime_at-min',
                    'label'   => '',
                    'value'   => $event_datetime_min,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
        <tr>
            <th><span class="pr-1">to</span></th>
            <td>
                @include('user.components.form-input', [
                    'type'    => 'datetime-local',
                    'name'    => 'event_datetime-max',
                    'label'   => '',
                    'value'   => $event_datetime_max,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
    </table>
</div>
