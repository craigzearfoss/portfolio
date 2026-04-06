@php
    use App\Models\Portfolio\JobCoworker;

    $level_id = $level_id ?? request()->query('level_id');

    $levels = [ '' => '' ];

    foreach (JobCoworker::LEVELS as $id=>$value) {
        $levels[$id] = $value;
    }
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'  => 'level_id',
        'label' => 'level',
        'value' => $level_id,
        'list'  => $levels,
        'style' => 'width: 7rem;',
    ])
</div>
