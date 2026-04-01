@php
    use App\Models\Career\JobBoard;

    $owner_id = $owner_id ?? request()->query('owner_id');
    $rating   = $rating ?? request()->query('rating');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'     => 'rating',
        'label'    => 'rating',
        'value'    => $rating,
        'list'     => [ '' => '', 1 => 1, 2 => 2, 3 => 3, 4 => 4 ],
        'style'    => 'width: 6rem;',
    ])
</div>
