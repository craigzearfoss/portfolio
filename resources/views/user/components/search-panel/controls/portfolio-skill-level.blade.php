@php
    use App\Models\Portfolio\Skill;

    $min_level = $min_level ?? request()->query('min_level');

    $levels = [ '' => '' ];

    foreach (Skill::LEVELS as $level=>$label) {
        $levels[$level] = $label;
    }
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'  => 'min_level',
        'label' => 'min level',
        'value' => $min_level,
        'list'  => $levels,
        'style' => 'width: 8rem;'
    ])
</div>
