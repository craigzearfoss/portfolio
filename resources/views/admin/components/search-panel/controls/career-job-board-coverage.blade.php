@php
    $coverage = $coverage ?? request()->query('coverage');

    $coverages = [
        ''              => '',
        'local'         => 'local',
        'regional'      => 'regional',
        'national'      => 'national',
        'international' => 'international',
    ];
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'coverage',
        'label'    => 'coverage',
        'value'    => $coverage,
        'list'     => $coverages,
        'style'    => 'width: 8rem;'
    ])
</div>
