@php
    use App\Models\Personal\Ingredient;

    // get variables
    $action          = $action ?? url()->current();
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $name            = $name ?? request()->query('name');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Ingredient::SEARCH_ORDER_BY[0], Ingredient::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="search-panel-controls">

                        @include('guest.components.search-sort-select', [
                            'sort' => $sort,
                            'list' => [
                                          'name|asc'    => 'name',
                                      ],
                        ])

                        @include('admin.components.button-clear', [
                            'id'   =>'clearSearchForm',
                            'name' => 'Clear',
                        ])

                        @include('admin.components.button-search', [
                            'id' =>'performSearch',
                        ])

                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'name',
                                'value'   => $name,
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
