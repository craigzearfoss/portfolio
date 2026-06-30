@php
    $updated_at_min = $updated_at_min ?? request()->query('updated_at_min');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at_max');
@endphp
<div class="card search-control-group">
    <table>
        <tr>
            <th colspan="2" class="has-text-centered">updated at</th>
        </tr>
        <tr>
            <th><span class="pr-1">from</span></th>
            <td>
                @include('admin.components.form-input', [
                    'type'    => 'datetime-local',
                    'name'    => 'updated_at-min',
                    'label'   => '',
                    'value'   => $updated_at_min,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
        <tr>
            <th><span class="pr-1">to</span></th>
            <td>
                @include('admin.components.form-input', [
                    'type'    => 'datetime-local',
                    'name'    => 'updated_at-max',
                    'label'   => '',
                    'value'   => $updated_at_max,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
    </table>
</div>
