@php
    use App\Models\Portfolio\Publication;
    use App\Models\System\Admin;

    // get variables
    $action           = $action ?? url()->current();
    $owner_id         = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $created_at_from  = $created_at_from ?? request()->query('created_at_from');
    $created_at_to    = $created_at_to ?? request()->query('created_at_to');
    $publication_name = $publication_name ?? request()->query('publication_name');
    $publisher        = $publisher ?? request()->query('publisher');
    $search_title     = $search_title ?? request()->query('search_title');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Publication::SEARCH_ORDER_BY[0], Publication::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('admin.components.search-sort-select', [
                        'sort' => $sort,
                        'list' => array_merge($isRootAdmin ? [ 'owner.username|asc' => 'owner' ] : [],
                                              [
                                                  'publication_name|asc' => 'publication',
                                                  'publisher|asc'        => 'publisher',
                                                  'title|asc'            => 'title',
                                                  'publication_year|asc' => 'year',
                                              ],
                                  ),
                        'style' => [ 'width: 7rem !important', 'max-width: 7rem !important' ],
                    ])

                    <?php /*
                    // @TODO: Implement clear search form functionality.
                    @include('admin.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    */ ?>

                    @include('admin.components.button-search', [
                        'id' =>'performSearch',
                    ])

                </div>

                <div class="floating-div-container">

                    @if($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif

                    <div class="floating-div">

                        <?php /*
                        // there are too many publications for a select list
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('admin.components.form-select', [
                                    'name'  => 'search_title',
                                    'label' => 'title',
                                    'value' => $search_title,
                                    'list'  => new Publication()->listOptions(
                                        !empty($owner->is_root) ? [] : (!empty($owner_id) ? [ 'owner_id' => $owner_id ] : []),
                                        'title',
                                        'title',
                                        true,
                                        false,
                                        [ 'title', 'asc' ],
                                    ),
                                    'style' => 'min-width: 15rem;'
                                ])
                            </div>
                        </div>
                        */ ?>

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'search_title',
                                'label'   => 'title',
                                'value'   => $search_title,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'publication_name',
                                'label'   => 'publication',
                                'value'   => $publication_name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('admin.components.input-basic', [
                                'name'    => 'publisher',
                                'value'   => $publisher,
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
