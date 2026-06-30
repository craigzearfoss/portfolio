@php
    $apply_date_min = $apply_date_min ?? request()->query('apply_date-min');
    $apply_date_max = $apply_date_max ?? request()->query('apply_date-max');
@endphp
<div class="card search-control-group">
    <table>
        <tr>
            <th colspan="2" class="has-text-centered">applied</th>
        </tr>
        <tr>
            <th><span class="pr-1">from</span></th>
            <td>
                @include('user.components.form-input', [
                    'type'    => 'date',
                    'name'    => 'apply_date_min',
                    'label'   => '',
                    'value'   => $apply_date_min,
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
                    'name'    => 'apply_date-max',
                    'label'   => '',
                    'value'   => $apply_date_max,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
    </table>
</div>
