@php
    use App\Models\Career\Company;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $city            = $city ?? request()->query('city');
    $industry_id     = $industry_id ?? request()->query('industry_id');
    $industry_name   = $industry_name ?? request()->query('industry_name');
    $name            = $name ?? request()->query('name');
    $state_id        = $state_id ?? request()->query('state_id');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Company::SEARCH_ORDER_BY[0], Company::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => [
                                       'name|asc'          => 'name',
                                       'industry_name|asc' => 'industry',
                                       'city|asc'          => 'city',
                                       'state_id|asc'      => 'state',
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
                            @include('user.components.search-panel.controls.career-industry')
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
