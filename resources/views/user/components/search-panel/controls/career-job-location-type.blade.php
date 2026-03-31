@php
    use App\Models\Career\JobLocationType;

    $job_location_type_id = $job_location_type_id ?? request()->query('job_location_type_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'     => 'job_location_type_id',
        'label'    => 'location type',
        'value'    => $job_location_type_id,
        'list'     => new JobLocationType()->listOptions(
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
