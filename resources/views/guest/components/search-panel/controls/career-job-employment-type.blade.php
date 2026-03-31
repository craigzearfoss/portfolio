@php
    use App\Models\Career\JobEmploymentType;

    $job_employment_type_id = $job_employment_type_id ?? request()->query('job_employment_type_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'job_employment_type_id',
        'label'    => 'type',
        'value'    => $job_employment_type_id,
        'list'     => new JobEmploymentType()->listOptions(
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
