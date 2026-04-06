@php
    use App\Models\Portfolio\Job;
    use App\Models\System\Admin;

    // get variables
    $action   = $action ?? url()->current();
    $owner_id = $owner->id ?? -1;
    $company  =  $company ?? request()->query('company');
    $role     = $role ?? request()->query('role');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Job::SEARCH_ORDER_BY[0], Job::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort' => $sort,
                        'list' => [
                                      'company|asc'     => 'company',
                                      'end_date|desc'   => 'end date',
                                      'role|asc'        => 'role',
                                      'start_date|desc' => 'start date',
                                  ],
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
                            @include('guest.components.input-basic', [
                                'name'    => 'company',
                                'value'   => $company,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
                                'name'    => 'role',
                                'value'   => $role,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
