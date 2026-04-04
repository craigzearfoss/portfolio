@php
    use App\Models\Career\Application;

    $min_rating = $min_rating ?? request()->query('min_rating');

    $ratings = [ '' => '' ];

    foreach (Application::RATINGS as $rating=>$label) {
        $ratings[$rating] = $label;
    }
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'  => 'min_rating',
        'label' => 'min rating',
        'value' => $min_rating,
        'list'  => $ratings,
        'style' => 'width: 8rem;'
    ])
</div>
