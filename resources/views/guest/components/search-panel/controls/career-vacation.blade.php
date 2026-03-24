@php
    $vacation = $vacation ?? request()->query('vacation');
@endphp
<div class="container control" style="width: 8rem;">
    @include('guest.components.form-checkbox', [
        'name'     => 'vacation',
        'value'    => 1,
        'checked'  => boolval(Request::get('vacation') ?? false),
        'nohidden' => true,
    ])
</div>
