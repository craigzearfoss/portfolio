@php
    use App\Enums\EnvTypes;
    use App\Models\System\User;

    // get variables
    $action          = $action ?? url()->current();
    $user_id         = $user->id ?? -1;
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ User::SEARCH_ORDER_BY[0], User::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new User()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
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
                        <div class="control" style="max-width: 30rem;">
                            @include('user.components.form-select', [
                                'name'  => 'user_id',
                                'label' => 'user',
                                'value' => $user_id,
                                'list'  => new User()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                                'style' => 'min-width: 10rem;'
                            ])
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
