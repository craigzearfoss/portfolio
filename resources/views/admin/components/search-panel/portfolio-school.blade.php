@php
    use App\Enums\EnvTypes;
    use App\Models\Portfolio\School;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $name            = $name ?? request()->query('name');
    $city            = $city ?? request()->query('city');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ School::SEARCH_ORDER_BY[0], School::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new School()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ]
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

                        <?php /* We don't currently have any cities in the portfolio.schools table.
                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'city',
                                'value'   => $city,
                                'message' => $message ?? '',
                            ])
                        </div>
                        */ ?>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.system-state')
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
