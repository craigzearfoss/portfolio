@php
    $relation = $relation ?? request()->query('relation');

    $relations = [
        ''             => '',
        'coworker'     => 'coworker',
        'family'       => 'family',
        'friend'       => 'friend',
        'professional' => 'professional',
        'subordinate'  => 'subordinate',
        'supervisor'   => 'supervisor',
        'other'        => 'other',
    ];
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'relation',
        'label'    => 'relation',
        'value'    => $relation,
        'list'     => $relations,
        'style'    => 'width: 8rem;'
    ])
</div>
