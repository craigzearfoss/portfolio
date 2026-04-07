@php
    use App\Models\System\Admin;
    use App\Models\System\Owner;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id = $owner->id ?? -1;
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Admin::SEARCH_ORDER_BY[0], Admin::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    <?php /*
                    // @TODO: Implement sort select list.
                    @include('user.components.search-sort-select', [
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
                    @include('user.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('user.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

            </div>

        </form>

    </div>

</div>
