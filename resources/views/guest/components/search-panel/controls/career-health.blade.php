@php
    $health   = $health ?? request()->query('health');
@endphp
<div class="container control" style="width: 8rem;">
    @include('guest.components.form-checkbox', [
        'name'     => 'health',
        'value'    => 1,
        'checked'  => boolval(Request::get('health') ?? false),
        'nohidden' => true,
    ])
</div>
