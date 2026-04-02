@php
    $health   = $health ?? request()->query('health');
@endphp
<div class="container control" style="width: 8rem;">
    @include('user.components.form-checkbox', [
        'name'     => 'health',
        'value'    => 1,
        'checked'  => boolval($health ?? false),
        'nohidden' => true,
    ])
</div>
