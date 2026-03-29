@php
    $meal           = $meal ?? request()->query('meal');

    $meals = [
        '' => '',
        'breakfast' => 'breakfast',
        'dinner'    => 'dinner',
        'lunch'     => 'lunch',
        'snack'     => 'snack',
    ];
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'  => 'meal',
        'value' => $meal,
        'list'  => $meals,
        'style' => 'width: 6rem;',
    ])
</div>
