@php
    $created_at_min = $created_at_min ?? request()->query('created_at_min');
    $created_at_max = $created_at_max ?? request()->query('created_at_max');
@endphp
<div class="card search-control-group">
     <table>
         <tr>
             <th colspan="2" class="has-text-centered">created at</th>
         </tr>
         <tr>
             <th><span class="pr-1">from</span></th>
             <td>
                 @include('admin.components.form-input-with-icon', [
                     'type'    => 'datetime-local',
                     'name'    => 'created_at-min',
                     'label'   => '',
                     'value'   => $created_at_min,
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
                     'name'    => 'created_at-max',
                     'label'   => '',
                     'value'   => $created_at_max,
                     'message' => $message ?? '',
                     'class'   => [ 'submit-search-on-enter-key' ],
                 ])
             </td>
         </tr>
     </table>
</div>
