@php
    use App\Models\Career\Resume;

    $owner_id   = $owner_id ?? request()->query('owner_id');
    $company_id = $company_id ?? request()->query('company_id');
    $resume_id  = $resume_id ?? request()->query('resume_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'resume_id',
        'label'    => 'resume',
        'value'    => $resume_id,
        'list'     => new Resume()->listOptions(
                          [ 'owner_id' => $owner_id ],
                          'id',
                          'name',
                          0,
                          false,
                          [ 'name', 'desc' ]
                      ),
        'onchange' => "document.getElementById('searchForm').submit()"
    ])
</div>
