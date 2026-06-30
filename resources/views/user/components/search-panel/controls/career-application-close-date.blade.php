@php
    $close_date_min = $close_date_min ?? request()->query('close_date-min');
    $close_date_max = $close_date_max ?? request()->query('close_date-max');
@endphp
<div class="card search-control-group">
    <table>
        <tr>
            <th colspan="2" class="has-text-centered">posted</th>
        </tr>
        <tr>
            <th><span class="pr-1">from</span></th>
            <td>
                @include('user.components.form-input', [
                    'type'    => 'date',
                    'name'    => 'close_date_min',
                    'label'   => '',
                    'value'   => $close_date_min,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
        <tr>
            <th><span class="pr-1">to</span></th>
            <td>
                @include('user.components.form-input', [
                    'type'    => 'date',
                    'name'    => 'close_date-max',
                    'label'   => '',
                    'value'   => $close_date_max,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
    </table>
</div>
