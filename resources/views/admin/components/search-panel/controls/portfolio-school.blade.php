@php
    use App\Models\Portfolio\School;

    $owner_id   = $owner_id ?? request()->query('owner_id');
    $isRootAmin = $isRootAmin ?? false;
    $school_id  = $school_id ?? request()->query('school_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
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
