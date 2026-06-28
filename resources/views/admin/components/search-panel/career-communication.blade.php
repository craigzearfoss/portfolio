@php
    use App\Enums\EnvTypes;
    use App\Models\Career\Application;
    use App\Models\Career\Communication;
    use App\Models\Career\Company;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action                     = $action ?? url()->current();
    $application_id             = $application_id ?? request()->query('application_id');
    $application_name           = $application_id ?? request()->query('application_id');
    $body                       = $body ?? request()->query('body');
    $company_id                 = $company_id ?? request()->query('company_id');
    $company_name               = $company_name ?? request()->query('company_name');
    $created_at_max             = $created_at_max ?? request()->query('created_at-max');
    $created_at_min             = $created_at_min ?? request()->query('created_at-min');
    $communication_datetime_max = $communication_datetime_max ?? request()->query('communication_datetime_max');
    $communication_datetime_min = $communication_datetime_min ?? request()->query('communication_datetime_min');
    $favorites                  = $favorites ?? request()->query('favorites');
    $from                       = $from ?? request()->query('from');
    $owner_id                   = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $subject                    = $subject ?? request()->query('subject');
    $to                         = $to ?? request()->query('to');
    $updated_at_max             = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min             = $updated_at_min ?? request()->query('updated_at-min');

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

    <div class="search-container card">

        <form id="searchForm" action="{!! $action ?? '' !!}"
              class="search-form"
              method="get"
        >

            <div>

                <div class="search-panel-header">

                    @include('admin.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Communication()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
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

                    @if ($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif

                    <div class="floating-div">

                        @if ($isRootAdmin || $applicationCount > 20)
                            <div class="search-form-control">
                                @include('admin.components.form-input-with-icon', [
                                    'name'    => 'application_name',
                                    'label'   => 'application',
                                    'value'   => $application_name,
                                    'message' => $message ?? '',
                                    'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                                ])
                            </div>
                        @else
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.career-application', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        <div class="search-form-control">
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
                                @include('admin.components.search-panel.controls.career-company',
                                    $isRootAdmin ? [] : [ 'owner_id' => $owner_id ]
                                )
                            @endif
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'from',
                                'value'   => $from,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'to',
                                'value'   => $to,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'subject',
                                'value'   => $subject,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.form-input-with-icon', [
                                'name'    => 'body',
                                'value'   => $body,
                                'message' => $message ?? '',
                                'class'   => [ 'input-name', 'submit-search-on-enter-key' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        @include('admin.components.search-panel.controls.career-communication-communication-datetime', [
                            'communication-datetime-min' => $communication_datetime_min,
                            'communication-datetime-max' => $communication_datetime_max,
                        ])

                        <div class="card search-control-group">
                            @include('admin.components.form-checkbox', [
                                'id'         => 'favoritesCheckBox',
                                'name'       => 'favorites',
                                'value'      => 1,
                                'checked'    => $favorites,
                                'nohidden'   => true,
                                'class'      => [ 'search-favorites' ],
                                'attributes' => [ 'data-resource' => 'career.communication' ]
                            ])
                        </div>

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
