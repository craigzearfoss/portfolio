@php
    $type = $type ?? request()->query('type');

    $types = [
        ''          => '',
        'appetizer' => 'appetizer',
        'beverage'  => 'beverage',
        'dessert'   => 'dessert',
        'main'      => 'main',
        'side'      => 'side',
    ];
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'  => 'type',
        'value' => $type,
        'list'  => $types,
        'style' => 'width: 7rem;',
    ])
</div>
