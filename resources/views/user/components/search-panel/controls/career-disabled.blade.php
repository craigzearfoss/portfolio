@php
    $disabled = $disabled ?? request()->query('disabled');
@endphp
<div class="container control" style="width: 8rem;">
    @include('user.components.form-checkbox', [
        'name'     => 'disabled',
        'value'    => 1,
        'checked'  => boolval($disabled ?? false),
        'nohidden' => true,
    ])
</div>
