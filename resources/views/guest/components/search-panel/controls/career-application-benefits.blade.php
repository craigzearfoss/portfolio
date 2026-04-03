@php
    $benefits = $benefits ?? request()->query('benefits');
@endphp
<div class="container control" style="width: 8rem;">
    @include('guest.components.form-checkbox', [
        'name'     => 'benefits',
        'value'    => 1,
        'checked'  => boolval($benefits ?? false),
        'nohidden' => true,
    ])
</div>
