@php
    use App\Models\Career\Application;
    use App\Models\Career\Communication;
    use App\Models\System\Admin;

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
                                                  //'application_id|asc'        => 'application',
                                                  'company_name|asc'            => 'company',
                                                  'communication_datetime|desc' => 'date',
                                                  'apply_date|desc'             => 'date applied',
                                                  'post_date|desc'              => 'date posted',
                                                  'from|asc'                    => 'from',
                                                  'subject|asc'                 => 'subject',
                                                  'to|asc'                      => 'to',
                                              ],
                                  ),
                        'style' => [ 'width: 8rem !important', 'max-width: 8rem !important' ]
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

                    <div class="floating-div">

                        @if($isRootAdmin)

                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>

                        @else

                            @php
                                /* There will be too many applications to create a select list for the root admin,
                                   so root admins should search by company. */
                            @endphp

                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.career-application', [ 'owner_id' => $owner_id ])
                            </div>

                        @endif

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
                            @if($isRootAdmin)
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

                        <?php /*
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'body',
                                'value'   => $body,
                                'message' => $message ?? '',
                            ])
                        </div>
                        */ ?>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'from',
                                'value'   => $from,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'to',
                                'value'   => $to,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'type'    => 'date',
                                'name'    => 'datetime_from',
                                'label'   => 'from date',
                                'value'   => $datetime_from,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
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
