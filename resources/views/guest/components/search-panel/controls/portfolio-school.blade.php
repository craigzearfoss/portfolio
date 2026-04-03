@php
    use App\Models\Portfolio\School;

    $school_id  = $school_id ?? request()->query('school_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'school_id',
        'label'    => 'school',
        'value'    => $school_id,
        'list'     => new School()->listOptions(
                          [],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'asc' ]
                      ),
        'style'    => 'min-width: 6rem;'
    ])
</div>
