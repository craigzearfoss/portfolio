@php
    $featured = $featured ?? request()->query('featured');
@endphp
<div class="container control" style="width: 8rem;">
    @include('admin.components.form-checkbox', [
        'name'     => 'featured',
        'value'    => 1,
        'checked'  => boolval($featured ?? false),
        'nohidden' => true,
    ])
</div>
