@php
    use App\Enums\EnvTypes;
    use App\Models\System\User;
    use App\Models\System\UserGroup;

    // get variables
    $action          = $action ?? url()->current();
    $user_id         = $user_id ?? $user->id ?? null;
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ UserGroup::SEARCH_ORDER_BY[0], UserGroup::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new UserGroup()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ]
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
                        <div class="control" style="max-width: 30rem;">
                            @include('guest.components.form-select', [
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
