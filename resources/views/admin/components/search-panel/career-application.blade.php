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
    $applied_from           = $applied_from ?? request()->query('applied_from');
    $applied_to             = $applied_to ?? request()->query('applied_to');
    $benefits               = $benefits ?? request()->query('benefits');
    $city                   = $city ?? request()->query('city');
    $close_date             = $close_date ?? request()->query('close_date');
    $closed_from            = $closed_from ?? request()->query('closed_from');
    $closed_to              = $closed_to ?? request()->query('closed_to');
    $company_id             = $company_id ?? request()->query('company_id');
    $company_name           = $company_name ?? request()->query('company_name');
    $health                 = $health ?? request()->query('health');
    $job_board_id           = $job_board_id ?? request()->query('job_board_id');
    $job_duration_type_id   = $job_duration_type_id ?? request('job_duration_type_id');
    $job_employment_type_id = $job_employment_type_id ?? request('job_employment_type_id');
    $job_location_type_id   = $job_location_type_id ?? request('job_location_type_id');
    $post_date              = $post_date ?? request()->query('post_date');
    $posted_from            = $posted_from ?? request()->query('posted_from');
    $posted_to              = $posted_to ?? request()->query('posted_to');
    $rating                 = $rating ?? request()->query('rating');
    $relocation             = $relocation ?? request()->query('relocation');
    $resume_id              = $resume_id ?? request()->query('resume_id');
    $resume_name            = $resume_name ?? request()->query('resume_name');
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
                            @include('admin.components.search-panel.controls.career-application-rating', [ 'rating' => $rating ])
                        </div>
                    </div>

                    <div class="floating-div">
                        @if($isRootAdmin)
                            <div class="search-form-control">
                                @include('admin.components.input-basic', [
                                    'name'    => 'company_name',
                                    'label'   => 'company',
                                    'value'   => $company_name,
                                    'message' => $message ?? '',
                                    'style'   => 'width: 16rem;'
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.career-company', [ 'company_id' => $company_id ])
                            </div>
                        @endif
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
                        @if($isRootAdmin)
                            <div class="search-form-control">
                                @include('admin.components.input-basic', [
                                    'name'    => 'resume_name',
                                    'label'   => 'resume',
                                    'value'   => $resume_name,
                                    'message' => $message ?? '',
                                    'style'   => 'width: 16rem;'
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.career-resume', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif
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
                            @include('admin.components.search-panel.controls.career-application-w2', [ 'w2' => $w2 ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-application-relocation', [ 'relocation' => $relocation ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-application-benefits', [ 'benefits' => $benefits ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-application-vacation', [ 'vacation' => $vacation ])
                        </div>
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-application-health', [ 'health' => $health ])
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
                        @include('admin.components.search-panel.controls.career-application-apply-date', [
                            'applied_from' => $applied_from,
                            'applied_to'   => $applied_to,
                        ])
                        @include('admin.components.search-panel.controls.career-application-post-date', [
                            'posted_from' => $posted_from,
                            'posted_to'   => $posted_to,
                        ])
                        <div style="display: none;">
                            @include('admin.components.search-panel.controls.career-application-close-date', [
                                'closed_from' => $closed_from,
                                'closed_to'   => $closed_to,
                             ])
                        </div>
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
