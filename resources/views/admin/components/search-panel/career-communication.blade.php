@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Application;
    use App\Models\Career\Communication;
    use App\Models\Career\Company;
    use App\Models\System\Admin;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action           = $action ?? url()->current();
    $owner_id         = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $application_id   = $application_id ?? request()->query('application_id');
    $application_name = $application_id ?? request()->query('application_id');
    $body             = $body ?? request()->query('body');
    $company_id       = $company_id ?? request()->query('company_id');
    $company_name     = $company_name ?? request()->query('company_name');
    $created_at_from  = $created_at_from ?? request()->query('created_at_from');
    $created_at_to    = $created_at_to ?? request()->query('created_at_to');
    $datetime_from    = $datetime_from ?? request()->query('datetime_from');
    $datetime_to      = $datetime_to ?? request()->query('datetime_to');
    $from             = $from ?? request()->query('from');
    $subject          = $subject ?? request()->query('subject');
    $to               = $to ?? request()->query('to');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Communication::SEARCH_ORDER_BY[0], Communication::SEARCH_ORDER_BY[1] ]);

    // get counts of companies and resumes
    // if there are more than 20 then we display an input text box instead of a select list
    $applicationCount = $isRootAdmin
        ? new Application()->query()->count()
        : new Application()->query()->where('owner_id', $admin->id)->count();

    $companyCount = $isRootAdmin
        ? new Company()->query()->count()
        : new Company()->query()->where('owner_id', $admin->id)->count();
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Communication()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ]
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

                <div class="floating-div-container">

                    @if($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif

                    <div class="floating-div">

                        @if($isRootAdmin || $applicationCount > 20)
                            <div class="search-form-control">
                                @include('admin.components.form-input-with-icon', [
                                    'name'    => 'application_name',
                                    'label'   => 'application',
                                    'value'   => $application_name,
                                    'message' => $message ?? '',
                                    'style'   => 'width: 16rem;'
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.career-application', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        <div class="search-form-control">
                            @if($isRootAdmin || $companyCount > 20)
                                <div class="search-form-control">
                                    @include('admin.components.form-input-with-icon', [
                                        'name'    => 'company_name',
                                        'label'   => 'company',
                                        'value'   => $company_name,
                                        'message' => $message ?? '',
                                    ])
                                </div>
                            @else
                                @include('admin.components.search-panel.controls.career-company',
                                    $isRootAdmin ? [] : [ 'owner_id' => $owner_id ]
                                )
                            @endif
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'subject',
                                'value'   => $subject,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'body',
                                'value'   => $body,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'from',
                                'value'   => $from,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'to',
                                'value'   => $to,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'type'    => 'date',
                                'name'    => 'datetime_from',
                                'label'   => 'from date',
                                'value'   => $datetime_from,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'type'    => 'date',
                                'name'    => 'datetime_to',
                                'label'   => 'to date',
                                'value'   => $datetime_to,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                    @if($isRootAdmin)
                        <div class="floating-div">
                            @include('admin.components.search-panel.controls.timestamp-created-at', [
                                'created_at_from' => $created_at_from,
                                'created_at_to'   => $created_at_to,
                            ])
                        </div>
                    @endif

                </div>

            </div>

        </form>

    </div>

</div>
