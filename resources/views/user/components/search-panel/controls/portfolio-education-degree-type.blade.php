@php
    use App\Models\Portfolio\DegreeType;

    $degree_type_id = $degree_type_id ?? request()->query('degree_type_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'     => 'degree_type_id',
        'label'    => 'degree',
        'value'    => $degree_type_id,
        'list'     => new DegreeType()->listOptions(
                          [],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'asc' ]
                      ),
        'style'    => 'width: 9rem;'
    ])
</div>
