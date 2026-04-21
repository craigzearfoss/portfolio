@php
    use App\Models\Career\Recruiter;

    // get variables
    $action          = $action ?? url()->current();
    $name            = $name ?? request()->query('name');
    $city            = $city ?? request()->query('city');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Recruiter::SEARCH_ORDER_BY[0], Recruiter::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort' => $sort,
                        'list' => [
                                       'city|asc'       => 'city',
                                       'name|asc'       => 'name',
                                       'state_name|asc' => 'state',
                                  ],
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
                            @include('user.components.input', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.career-recruiter-coverage_area')
                        </div>

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

                </div>

            </div>

        </form>

    </div>

</div>
