@php
    $w2 = $w2 ?? request()->query('w2');
@endphp
<div class="container control" style="width: 8rem;">
    @include('user.components.form-checkbox', [
        'name'     => 'w2',
        'value'    => 1,
        'checked'  => boolval(Request::get('w2') ?? false),
        'nohidden' => true,
    ])
</div>
