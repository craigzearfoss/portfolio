@php
    use App\Models\Career\Note;
    use App\Models\System\Admin;

    // get variables
    $action           = $action ?? url()->current();
    $owner_id         = $owner->id ?? -1;
    $application_name = $application_id ?? request()->query('application_id');
    $body             = $body ?? request()->query('body');
    $company_id       = $company_id ?? request()->query('company_id');
    $company_name     = $company_name ?? request()->query('company_name');
    $created_at_from  = $created_at_from ?? request()->query('created_at_from');
    $created_at_to    = $created_at_to ?? request()->query('created_at_to');
    $subject          = $subject ?? request()->query('subject');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Note::SEARCH_ORDER_BY[0], Note::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => [
                                       //'application_id|asc'        => 'application',
                                       'company_name|asc'            => 'company',
                                       'created_at|desc'             => 'datetime created',
                                       'apply_date|desc'             => 'date applied',
                                       'post_date|desc'              => 'date posted',
                                       'from|asc'                    => 'from',
                                       'subject|asc'                 => 'subject',
                                       'to|asc'                      => 'to',
                                   ],
                        'style' => [ 'width: 10rem', 'max-width: 10rem' ]
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
                                @include('user.components.search-panel.controls.career-application', [ 'owner_id' => $owner_id ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'subject',
                                'value'   => $subject,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-company',
                                [ 'owner_id' => $owner_id ]
                            )
                        </div>

                        <?php /*
                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'body',
                                'value'   => $body,
                                'message' => $message ?? '',
                            ])
                        </div>
                        */ ?>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
