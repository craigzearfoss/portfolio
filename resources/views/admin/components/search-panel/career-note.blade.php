@php
    use App\Models\Career\Application;
    use App\Models\Career\Company;
    use App\Models\Career\Note;
    use App\Models\System\Admin;

    // get variables
    $action           = $action ?? url()->current();
    $owner_id         = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));    $application_id   = $application_id ?? request()->query('application_id');
    $application_name = $application_id ?? request()->query('application_id');
    $body             = $body ?? request()->query('body');
    $company_id       = $company_id ?? request()->query('company_id');
    $company_name     = $company_name ?? request()->query('company_name');
    $created_at_from  = $created_at_from ?? request()->query('created_at_from');
    $created_at_to    = $created_at_to ?? request()->query('created_at_to');
    $subject          = $subject ?? request()->query('subject');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Note::SEARCH_ORDER_BY[0], Note::SEARCH_ORDER_BY[1] ]);

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
                        'list'  => array_merge($isRootAdmin ? [ 'owner.username|asc' => 'owner' ] : [],
                                              [
                                                   //'application_id|asc'          => 'application',
                                                   'company_name|asc'            => 'company',
                                                   'created_at|desc'             => 'datetime created',
                                                   'application_apply_date|desc' => 'date applied',
                                                   'application_post_date|desc'  => 'date posted',
                                                   'from|asc'                    => 'from',
                                                   'subject|asc'                 => 'subject',
                                                   'to|asc'                      => 'to',
                                                   'updated_at|desc'             => 'updated at',
                                               ],
                                   ),
                        'style' => [ 'width: 10rem', 'max-width: 10rem' ]
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

                        @if(!$isRootAdmin || $applicationCount > 20)
                            <div class="search-form-control">
                                @include('admin.components.input-basic', [
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
                                    @include('admin.components.input-basic', [
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
                            @include('admin.components.input-basic', [
                                'name'    => 'subject',
                                'value'   => $subject,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'body',
                                'value'   => $body,
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
