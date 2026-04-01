@php
    use App\Models\Career\JobDurationType;

    $job_duration_type_id = $job_duration_type_id ?? request()->query('job_duration_type_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'job_duration_type_id',
        'label'    => 'duration',
        'value'    => $job_duration_type_id,
        'list'     => new JobDurationType()->listOptions(
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
