@php
    use App\Models\Personal\Recipe;

    $type = $type ?? request()->query('type');

    $types = [ '' => '' ];

    foreach (Recipe::TYPES as $key=>$value) {
        $types[$key] = $value;
    }
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'  => 'type',
        'value' => $type,
        'list'  => $types,
        'style' => 'width: 7rem;',
    ])
</div>
