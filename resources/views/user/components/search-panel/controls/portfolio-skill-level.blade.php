@php
    use App\Models\Portfolio\Skill;

    $level_min = $level_min ?? request()->query('level-min');

    $levels = [ '' => '' ];

    foreach (Skill::LEVELS as $level=>$label) {
        $levels[$level] = $label;
    }
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'  => 'level-min',
        'label' => 'skill level',
        'value' => $level_min,
        'list'  => $levels,
        'style' => 'width: 4rem;'
    ])
</div>
