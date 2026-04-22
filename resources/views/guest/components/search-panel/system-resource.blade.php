@php
    use App\Enums\EnvTypes;
    use App\Models\System\Database;
    use App\Models\System\Resource;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $database_id     = $database_id ?? request()->query('database_id');
    $name            = $name ?? request()->query('name');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Resource::SEARCH_ORDER_BY[0], Resource::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Resource()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
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
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('guest.components.form-select', [
                                    'name'     => 'database_id',
                                    'label'    => 'database',
                                    'value'    => $database_id,
                                    'list'     => new Database()->listOptions(
                                                      [ 'owner_id' => 1 ],
                                                      'id',
                                                      'tag',
                                                      true,
                                                      false,
                                                      [ 'tag', 'asc' ]
                                                  ),
                                    'style'    => 'width: 8rem;'
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('guest.components.form-select', [
                                    'name'     => 'name',
                                    'label'    => 'name',
                                    'value'    => $name,
                                    'list'     => new Resource()->listOptions(
                                                      [ 'owner_id' => $owner_id ],
                                                      'name',
                                                      'name',
                                                      true,
                                                      false,
                                                      [ 'name', 'asc' ]
                                                  ),
                                    'style'    => 'width: 8rem;'
                                ])
                            </div>
                        </div>
                    </div>


                </div>

            </div>

        </form>

    </div>

</div>
