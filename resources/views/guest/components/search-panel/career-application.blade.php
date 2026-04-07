@php
    use App\Models\Career\Application;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $applied_from    = $applied_from ?? request()->query('applied_from');
    $applied_to      = $applied_to ?? request()->query('applied_to');
    $city            = $city ?? request()->query('city');
    $closed_from     = $closed_from ?? request()->query('closed_from');
    $closed_to       = $closed_to ?? request()->query('closed_to');
    $company_name    = $company_name ?? request()->query('company_name');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $posted_from     = $posted_from ?? request()->query('posted_from');
    $posted_to       = $posted_to ?? request()->query('posted_to');
    $resume_name     = $resume_name ?? request()->query('resume_name');
    $role            = $role ?? request()->query('role');
    $wage_rate       = $wage_rate ?? request()->query('wage_rate');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Application::SEARCH_ORDER_BY[0], Application::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => [
                                       'company_name|asc'      => 'company',
                                       //'compensation_max|desc' => 'compensation (max)',
                                       //'compensation_min|desc' => 'compensation (min)',
                                       'apply_date|desc'       => 'date applied',
                                       'close_date|desc'       => 'date closed',
                                       'post_date|desc'        => 'date posted',
                                       'rating|desc'           => 'rating',
                                       'role|asc'              => 'role',
                                       'wage_rate|desc'        => 'wage',
                                   ],
                        'style' => [ 'width: 8rem !important', 'max-width: 8rem !important'],
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('guest.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('guest.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="floating-div-container">

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-application-status')
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-application-rating')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-company', [ 'owner_id' => $owner_id ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'role',
                                'value'   => $role,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-job-board')
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-resume', [ 'owner_id' => $owner_id ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-job-duration-type')
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-job-employment-type')
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-job-location-type')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-application-w2')
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-application-relocation')
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-application-benefits')
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-application-vacation')
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.career-application-health')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.system-state')
                        </div>

                    </div>

                    <div class="floating-div">

                        @include('guest.components.search-panel.controls.career-application-apply-date', [
                            'applied_from' => $applied_from,
                            'applied_to'   => $applied_to,
                        ])

                        @include('guest.components.search-panel.controls.career-application-post-date', [
                            'posted_from' => $posted_from,
                            'posted_to'   => $posted_to,
                        ])

                        <div style="display: none;">
                            @include('guest.components.search-panel.controls.career-application-close-date', [
                                'closed_from' => $closed_from,
                                'closed_to'   => $closed_to,
                             ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
