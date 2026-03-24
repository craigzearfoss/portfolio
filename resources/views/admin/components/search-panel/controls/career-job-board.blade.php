@php
    use App\Models\Career\JobBoard;

    $job_board_id = $job_board_id ?? request()->query('job_board_id');
@endphp
<div class="control" style="max-width: 28rem;">
    @include('admin.components.form-select', [
        'name'     => 'job_board_id',
        'label'    => 'job board',
        'value'    => $job_board_id,
        'list'     => new JobBoard()->listOptions(
                          [],
                          'id',
                          'name',
                          0,
                          false,
                          [ 'name', 'asc' ]
                      ),
    ])
</div>
