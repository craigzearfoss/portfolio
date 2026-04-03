@php
    $primary = $primary ?? request()->query('primary');
@endphp
<div class="container control" style="width: 8rem;">
    @include('guest.components.form-checkbox', [
        'name'     => 'primary',
        'value'    => 1,
        'checked'  => boolval($primary ?? false),
        'nohidden' => true,
    ])
</div>
