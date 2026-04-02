@php
    $vacation = $vacation ?? request()->query('vacation');
@endphp
<div class="container control" style="width: 8rem;">
    @include('admin.components.form-checkbox', [
        'name'     => 'vacation',
        'value'    => 1,
        'checked'  => boolval($vacation ?? false),
        'nohidden' => true,
    ])
</div>
