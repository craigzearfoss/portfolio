@php
    $deleted_at_min = $deleted_at_min ?? request()->query('deleted_at_min');
    $deleted_at_max = $deleted_at_max ?? request()->query('deleted_at_max');
@endphp
<div class="card search-control-group">
    <table>
        <tr>
            <th colspan="2" class="has-text-centered">deleted at</th>
        </tr>
        <tr>
            <th><span class="pr-1">from</span></th>
            <td>
                @include('admin.components.form-input', [
                    'type'    => 'datetime-local',
                    'name'    => 'deleted_at-min',
                    'label'   => '',
                    'value'   => $deleted_at_min,
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
                    'name'    => 'deleted_at-max',
                    'label'   => '',
                    'value'   => $deleted_at_max,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
    </table>
</div>
