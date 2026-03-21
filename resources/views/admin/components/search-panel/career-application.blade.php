@php
    use App\Models\System\Admin;

    $owner_id          = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $admin_database_id = $admin_database_id ?? request()->query('company_id');
    $job_board_id      = $job_board_id ?? request()->query('job_board_id');
    $resume_id         = $resume_id ?? request()->query('resume_id');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            @include('admin.components.search-panel.controls.owner', [ 'owner_id' => $owner_id ])

            @include('admin.components.search-panel.controls.career-company', [ 'company_id' => $company_id ])

            @include('admin.components.search-panel.controls.career-job-board', [ 'job_board_id' => $job_board_id ])

            @include('admin.components.search-panel.controls.career-resume', [ 'resume_id' => $resume_id ])

        </form>

    </div>

</div>
