@php
    use App\Models\Portfolio\Job;

    $owner_id   = $owner->id ?? -1;
    $job_id     = $job_id ?? request()->query('job_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('user.components.form-select', [
        'name'     => 'job_id',
        'label'    => 'job',
        'value'    => $job_id,
        'list'     => new Job()->listOptions(
                          [ 'owner_id' => $owner_id ],
                          'id',
                          'name',
                          true,
                          false,
                          []
                      ),
        'style'    => 'min-width: 20rem;'
    ])
</div>
