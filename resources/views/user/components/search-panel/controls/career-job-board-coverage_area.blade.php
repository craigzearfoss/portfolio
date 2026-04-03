@php
    use App\Models\Career\JobBoard;

    $coverage_area = $coverage_area ?? request()->query('coverage_area');

    $coverages = [ '' => '' ];

    foreach (JobBoard::COVERAGE_AREAS as $coverage) {
        $coverages[$coverage] = $coverage;
    }
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'     => 'coverage_area',
        'label'    => 'coverage',
        'value'    => $coverage_area,
        'list'     => $coverages,
        'style'    => 'width: 8rem;'
    ])
</div>
