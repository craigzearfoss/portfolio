@php
    use App\Models\Personal\Ingredient;

    // get variables
    $action = $action ?? url()->current();
    $name   = $name ?? request()->query('name');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Ingredient::SEARCH_ORDER_BY[0], Ingredient::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort' => $sort,
                        'list' => [
                                      'name|asc'    => 'name',
                                  ],
                    ])

                    @include('guest.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])

                    @include('guest.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="floating-div">

                    <div class="search-form-control">
                        @include('guest.components.input-basic', [
                            'name'    => 'name',
                            'value'   => $name,
                            'message' => $message ?? '',
                        ])
                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
