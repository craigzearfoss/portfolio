@php
    use App\Models\Career\Resume;

    $owner_id   = $owner_id ?? request()->query('owner_id');
    $isRootAmin = $isRootAmin ?? false;
    $company_id = $company_id ?? request()->query('company_id');
    $resume_id  = $resume_id ?? request()->query('resume_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'resume_id',
        'label'    => 'resume',
        'value'    => $resume_id,
        'list'     => new Resume()->listOptions(
                          $isRootAmin ? [] : [ 'owner_id' => $owner_id ],
                          'id',
                          'name',
                          true,
                          false,
                          [ 'name', 'desc' ]
                      ),
        'style'    => 'min-width: 15rem;'
    ])
</div>
