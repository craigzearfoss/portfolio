@php
    use App\Models\Personal\Recipe;

    $meal = $meal ?? request()->query('meal');

    $meals = [ '' => '' ];

    foreach (Recipe::MEALS as $key=>$value) {
        $meals[$key] = $value;
    }
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'  => 'meal',
        'value' => $meal,
        'list'  => $meals,
        'style' => 'width: 7rem;',
    ])
</div>
