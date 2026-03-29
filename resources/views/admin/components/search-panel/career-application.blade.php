@php
    use App\Models\System\Admin;

    $owner_id               = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    if (!isset($active)) {
        $active = request()->query('active');
        if (is_null($active)) {
            $active = 3;
        }
    }
    $admin_database_id      = $admin_database_id ?? request()->query('company_id');
    $apply_date             = $apply_date ?? request()->query('apply_date');
    $apply_from             = $apply_from ?? request()->query('apply_from');
    $apply_to               = $apply_to ?? request()->query('apply_to');
    $benefits               = $benefits ?? request()->query('benefits');
    $city                   = $city ?? request()->query('city');
    $close_date             = $close_date ?? request()->query('close_date');
    $health                 = $health ?? request()->query('health');
    $job_board_id           = $job_board_id ?? request()->query('job_board_id');
    $job_duration_type_id   = $job_duration_type_id ?? request('job_duration_type_id');
    $job_employment_type_id = $job_employment_type_id ?? request('job_employment_type_id');
    $job_location_type_id   = $job_location_type_id ?? request('job_location_type_id');
    $post_date              = $post_date ?? request()->query('post_date');
    $post_from              = $post_from ?? request()->query('post_from');
    $post_to                = $post_to ?? request()->query('post_to');
    $rating                 = $rating ?? request()->query('rating');
    $relocation             = $relocation ?? request()->query('relocation');
    $resume_id              = $resume_id ?? request()->query('resume_id');
    $role                   = $role ?? request()->query('role');
    $state_id               = $state_id ?? request()->query('state_id');
    $vacation               = $vacation ?? request()->query('vacation');
    $w2                     = $w2 ?? request()->query('w2');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        @if($isRootAdmin)
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-active', [ 'active' => $active ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-rating', [ 'rating' => $rating ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-company', [ 'company_id' => $company_id ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'role',
                                'value'   => $role,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-job-board', [ 'job_board_id' => $job_board_id ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-resume', [ 'owner_id' => $owner_id ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-job-duration-type', [ 'job_duration_type_id' => $job_duration_type_id ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-job-employment-type', [ 'job_employment_type_id' => $job_employment_type_id ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-job-location-type', [ 'job_location_type_id' => $job_location_type_id ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-w2', [ 'w2' => $w2 ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-relocation', [ 'relocation' => $relocation ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-benefits', [ 'benefits' => $benefits ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-vacation', [ 'vacation' => $vacation ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-health', [ 'health' => $health ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                            ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.system-state', [ 'state_id' => $state_id ])
                        </div>
                    </div>

                    <div class="floating-div">
                        @include('admin.components.search-panel.controls.career-apply-date', [
                            'appy_from' => $apply_from,
                            'appy_to'   => $apply_to,
                         ])
                        @include('admin.components.search-panel.controls.career-post-date', [
                            'appy_from' => $post_from,
                            'appy_to'   => $post_to,
                         ])
                    </div>

                </div>
                <div class="has-text-right pr-2">
                    @include('admin.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    @include('admin.components.button-search', [
                        'id' =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
