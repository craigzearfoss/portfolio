@php
    use App\Models\Career\Recruiter;

    $coverage_area = $coverage_area ?? request()->query('coverage_area');

    $coverages = [ '' => '' ];

    foreach (Recruiter::COVERAGE_AREAS as $coverage) {
        $coverages[$coverage] = $coverage;
    }
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'coverage_area',
        'label'    => 'coverage',
        'value'    => $coverage_area,
        'list'     => $coverages,
        'style'    => 'width: 8rem;'
    ])
</div>
