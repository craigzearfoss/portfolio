@php
    $post_date_min = $post_date_min ?? request()->query('post_date-min');
    $post_date_max = $post_date_max ?? request()->query('post_date-max');
@endphp
<div class="card search-control-group">
    <table>
        <tr>
            <th colspan="2" class="has-text-centered">posted</th>
        </tr>
        <tr>
            <th><span class="pr-1">from</span></th>
            <td>
                @include('admin.components.form-input-with-icon', [
                    'type'    => 'date',
                    'name'    => 'post_date_min',
                    'label'   => '',
                    'value'   => $post_date_min,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
        <tr>
            <th><span class="pr-1">to</span></th>
            <td>
                @include('admin.components.form-input', [
                    'type'    => 'date',
                    'name'    => 'post_date-max',
                    'label'   => '',
                    'value'   => $post_date_max,
                    'message' => $message ?? '',
                    'class'   => [ 'submit-search-on-enter-key' ],
                ])
            </td>
        </tr>
    </table>
</div>
