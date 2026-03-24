@php
    $benefits = $benefits ?? request()->query('benefits');
@endphp
<div class="container control" style="width: 8rem;">
    @include('user.components.form-checkbox', [
        'name'     => 'benefits',
        'value'    => 1,
        'checked'  => boolval(Request::get('benefits') ?? false),
        'nohidden' => true,
    ])
</div>
