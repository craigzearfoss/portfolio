@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Application;
    use App\Models\Career\Company;
    use App\Models\Career\Resume;
    use App\Models\System\Admin;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $applied_from    = $applied_from ?? request()->query('applied_from');
    $applied_to      = $applied_to ?? request()->query('applied_to');
    $city            = $city ?? request()->query('city');
    $closed_from     = $closed_from ?? request()->query('closed_from');
    $closed_to       = $closed_to ?? request()->query('closed_to');
    $company_name    = $company_name ?? request()->query('company_name');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');
    $posted_from     = $posted_from ?? request()->query('posted_from');
    $posted_to       = $posted_to ?? request()->query('posted_to');
    $resume_name     = $resume_name ?? request()->query('resume_name');
    $role            = $role ?? request()->query('role');
    $wage_rate       = $wage_rate ?? request()->query('wage_rate');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Application::SEARCH_ORDER_BY[0], Application::SEARCH_ORDER_BY[1] ]);

    // get counts of companies and resumes
    // if there are more than 20 resumes then we display an input text box instead of a select list
    $companyCount = new Company()->query()->where('owner_id', $admin->id)->count();
    $resumeCount = new Resume()->query()->where('owner_id', $admin->id)->count();
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Application()->getSortOptions($sort, EnvTypes::GUEST),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important'],
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('user.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('user.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="floating-div-container">

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-application-status')
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-application-rating')
                        </div>

                    </div>
                    <div class="floating-div">

                        @if($companyCount > 20)
                            <div class="search-form-control">
                                @include('user.components.input', [
                                    'name'    => 'company_name',
                                    'label'   => 'company',
                                    'value'   => $company_name,
                                    'message' => $message ?? '',
                                    'style'   => 'width: 16rem;'
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('user.components.search-panel.controls.career-company', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'role',
                                'value'   => $role,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-job-board')
                        </div>

                        @if($resumeCount > 20)
                            <div class="search-form-control">
                                @include('user.components.input', [
                                    'name'    => 'resume_name',
                                    'label'   => 'resume',
                                    'value'   => $resume_name,
                                    'message' => $message ?? '',
                                    'style'   => 'width: 16rem;'
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('user.components.search-panel.controls.career-resume', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-job-duration-type')
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-job-employment-type')
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-job-location-type')
                        </div>

                    </div>
                    <div class="floating-div">

                        @include('user.components.form-checkbox', [
                            'name'     => 'w2',
                            'value'    => 1,
                            'checked'  => $w2,
                            'nohidden' => true,
                        ])

                        @include('user.components.form-checkbox', [
                            'name'     => 'relocation',
                            'value'    => 1,
                            'checked'  => $relocation,
                            'nohidden' => true,
                        ])

                        @include('user.components.form-checkbox', [
                            'name'     => 'benefits',
                            'value'    => 1,
                            'checked'  => $benefits,
                            'nohidden' => true,
                        ])

                        @include('user.components.form-checkbox', [
                            'name'     => 'vacation',
                            'value'    => 1,
                            'checked'  => $vacation,
                            'nohidden' => true,
                        ])

                        @include('user.components.form-checkbox', [
                            'name'     => 'health',
                            'value'    => 1,
                            'checked'  => $health,
                            'nohidden' => true,
                        ])

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.system-state')
                        </div>

                    </div>

                    <div class="floating-div">

                        @include('user.components.search-panel.controls.career-application-apply-date', [
                            'applied_from' => $applied_from,
                            'applied_to'   => $applied_to,
                        ])

                        @include('user.components.search-panel.controls.career-application-post-date', [
                            'posted_from' => $posted_from,
                            'posted_to'   => $posted_to,
                        ])

                        <div style="display: none;">
                            @include('user.components.search-panel.controls.career-application-close-date', [
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
