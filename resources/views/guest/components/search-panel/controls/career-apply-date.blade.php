@php
    $apply_date = $apply_date ?? request()->query('apply_date');
@endphp
<div>

</div>
<div class="container control" style="width: 8rem;">
    @include('guest.components.form-checkbox', [
        'name'     => 'relocation',
        'value'    => 1,
        'checked'  => boolval(Request::get('relocation') ?? false),
        'nohidden' => true,
    ])
</div>
