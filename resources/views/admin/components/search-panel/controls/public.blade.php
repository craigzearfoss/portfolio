@php
    $public = $public ?? request()->query('public');
@endphp
<div class="container control" style="width: 8rem;">
    @include('admin.components.form-checkbox', [
        'name'     => 'public',
        'value'    => 1,
        'checked'  => boolval($public ?? false),
        'nohidden' => true,
    ])
</div>
