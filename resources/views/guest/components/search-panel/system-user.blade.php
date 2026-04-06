@php
    use App\Models\System\User;

    // get variables
    $action  = $action ?? url()->current();
    $user_id = $user_id ?? $user->id ?? null;

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ User::SEARCH_ORDER_BY[0], User::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    <?php /*
                    // @TODO: Implement sort select list.
                    @include('guest.components.search-sort-select', [
                        'sort' => $sort,
                        'list' => array_merge($isRootAdmin ? [ 'owner.username|asc' => 'owner' ] : [],
                                              [
                                                  'username'       => 'owner',
                                              ],
                                  ),
                        'style' => [ 'width: 7rem', 'max-width: 7rem' ],
                    ])
                    */ ?>

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
                                'name'     => 'user_id',
                                'label'    => 'user',
                                'value'    => $user_id,
                                'list'     => new User()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                            ])
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
