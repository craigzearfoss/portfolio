@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Application;
    use App\Models\Career\Company;
    use App\Models\Career\Resume;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $apply_date_max = $apply_date_max ?? request()->query('apply_date-max');
    $apply_date_min = $apply_date_min ?? request()->query('apply_date-min');
    $benefits       = $benefits ?? request()->query('benefits');
    $city           = $city ?? request()->query('city');
    $close_date_max = $close_date_max ?? request()->query('close_date-max');
    $close_date_min = $close_date_min ?? request()->query('close_date-min');
    $company_name   = $company_name ?? request()->query('company_name');
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $favorites      = $favorites ?? request()->query('favorites');
    $health         = $health ?? request()->query('health');
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $post_date_max  = $post_date_max ?? request()->query('post_date-max');
    $post_date_min  = $post_date_min ?? request()->query('post_date-min');
    $relocation     = $relocation ?? request()->query('relocation');
    $resume_name    = $resume_name ?? request()->query('resume_name');
    $role           = $role ?? request()->query('role');
    $wage_rate      = $wage_rate ?? request()->query('wage_rate');
    $updated_at_max = $created_at_max ?? request()->query('created_at-max');
    $updated_at_min = $created_at_min ?? request()->query('created_at-min');
    $vacation       = $vacation ?? request()->query('vacation');
    $w2             = $w2 ?? request()->query('w2');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Application::SEARCH_ORDER_BY[0], Application::SEARCH_ORDER_BY[1] ]);

    // get counts of companies and resumes
    // if there are more than 20 resumes then we display an input text box instead of a select list
    $companyCount = $isRootAdmin
        ? new Company()->query()->count()
        : new Company()->query()->where('owner_id', $admin->id)->count();

    $resumeCount = $isRootAdmin
        ? new Resume()->query()->count()
        : new Resume()->query()->where('owner_id', $admin->id)->count();
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}"
              class="search-form"
              method="get"
        >

            <div>

                <div class="search-panel-header">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Application()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('admin.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('admin.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="search-panel-body floating-div-container">

                    <div class="floating-div">

                        @if ($isRootAdmin)
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner')
                            </div>
                        @endif

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-application-status')
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-application-rating')
                        </div>

                    </div>
                    <div class="floating-div">

                        @if ($isRootAdmin || $companyCount > 20)
                            <div class="search-form-control">
                                @include('admin.components.form-input-with-icon', [
                                    'name'    => 'company_name',
                                    'label'   => 'company',
                                    'value'   => $company_name,
                                    'message' => $message ?? '',
                                    'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.career-company', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'role',
                                'value'   => $role,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-job-board')
                        </div>

                        @if ($isRootAdmin || $resumeCount > 20)
                            <div class="search-form-control">
                                @include('admin.components.form-input-with-icon', [
                                    'name'    => 'resume_name',
                                    'label'   => 'resume',
                                    'value'   => $resume_name,
                                    'message' => $message ?? '',
                                    'class'   => [ 'select-name', 'submit-search-on-enter-key' ],
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
                            @include('admin.components.search-panel.controls.career-job-duration-type')
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-job-employment-type')
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.career-job-location-type')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="card search-control-group">

                            @include('admin.components.form-checkbox', [
                                'name'     => 'w2',
                                'value'    => 1,
                                'checked'  => $w2,
                                'nohidden' => true,
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'     => 'relocation',
                                'value'    => 1,
                                'checked'  => $relocation,
                                'nohidden' => true,
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'     => 'benefits',
                                'value'    => 1,
                                'checked'  => $benefits,
                                'nohidden' => true,
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'     => 'vacation',
                                'value'    => 1,
                                'checked'  => $vacation,
                                'nohidden' => true,
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'     => 'health',
                                'value'    => 1,
                                'checked'  => $health,
                                'nohidden' => true,
                            ])

                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                                'class'   => [ 'input-city', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.system-state')
                        </div>

                        <div class="card search-control-group">
                            @include('admin.components.form-checkbox', [
                                'id'         => 'favoritesCheckBox',
                                'name'       => 'favorites',
                                'value'      => 1,
                                'checked'    => $favorites,
                                'nohidden'   => true,
                                'class'      => [ 'search-favorites' ],
                                'attributes' => [ 'data-resource' => 'career.application' ]
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        @include('admin.components.search-panel.controls.career-application-post-date', [
                            'post_date-min' => $post_date_min,
                            'post_date-max' => $post_date_max,
                        ])

                        @include('admin.components.search-panel.controls.career-application-apply-date', [
                            'apply_date-min' => $apply_date_min,
                            'apply_date-max' => $apply_date_max,
                        ])

                        @include('admin.components.search-panel.controls.career-application-close-date', [
                            'close_date-min' => $close_date_min,
                            'close_date-max' => $close_date_max,
                        ])

                    </div>

                    @if ($isRootAdmin)
                        <div class="floating-div">

                            @include('admin.components.search-panel.controls.timestamp-created-at', [
                                'created_at-min' => $created_at_min,
                                'created_at-max' => $created_at_max,
                            ])

                            @include('admin.components.search-panel.controls.timestamp-updated-at', [
                                'updated_at-min' => $updated_at_min,
                                'updated_at-max' => $updated_at_max,
                            ])

                        </div>
                    @endif

                </div>

            </div>

        </form>

    </div>

</div>
