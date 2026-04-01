@php
    use App\Models\Portfolio\Job;

    $owner_id   = $owner_id ?? request()->query('owner_id');
    $isRootAmin = $isRootAmin ?? false;
    $job_id     = $job_id ?? request()->query('job_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('guest.components.form-select', [
        'name'     => 'job_id',
        'label'    => 'job',
        'value'    => $job_id,
        'list'     => new Job()->listOptions(
                          $isRootAmin ? [] : [ 'owner_id' => $owner_id ],
                          'id',
                          'name',
                          true,
                          false,
                          []
                      ),
        'style'    => 'min-width: 6rem;'
    ])
</div>
