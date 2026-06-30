@php
    $communication_datetime_min = $communication_datetime_min ?? request()->query('communication_datetime-min');
    $communication_datetime_max = $communication_datetime_max ?? request()->query('communication_datetime-max');
@endphp
<div class="card search-control-group">
    <table>
        <tr>
            <th colspan="2" class="has-text-centered">datetime</th>
        </tr>
        <tr>
            <th><span class="pr-1">from</span></th>
            <td>
                @include('guest.components.form-input', [
                    'type'    => 'datetime-local',
                    'name'    => 'communication_datetime-min',
                    'label'   => '',
                    'value'   => $communication_datetime_min,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
        <tr>
            <th><span class="pr-1">to</span></th>
            <td>
                @include('guest.components.form-input', [
                    'type'    => 'datetime-local',
                    'name'    => 'communication_datetime-max',
                    'label'   => '',
                    'value'   => $communication_datetime_max,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
    </table>
</div>
