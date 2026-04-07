@php
    use App\Models\Career\Reference;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $city            = $city ?? request()->query('city');
    $company_name    = $company_name ?? request()->query('company_name');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $email           = $email ?? request()->query('email');
    $name            = $name ?? request()->query('name');
    $phone           = $phone ?? request()->query('phone');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Reference::SEARCH_ORDER_BY[0], Reference::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => [
                                       'company_name|asc'           => 'company',
                                       'communication_datetime|desc' => 'date',
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
                            @include('user.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-reference-relation', [ 'owner_id' => $owner_id ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'email',
                                'value'   => $email,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'phone',
                                'value'   => $phone,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.input-basic', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.system-state')
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
