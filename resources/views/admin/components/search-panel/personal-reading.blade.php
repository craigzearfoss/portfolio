@php
    use App\Models\Personal\Reading;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $audio           = boolval($audio ?? request()->query('audio'));
    $author          = $author ?? request()->query('author');
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $fiction         = boolval($fiction ?? request()->query('fiction'));
    $nonfiction      = boolval($nonfiction ?? request()->query('nonfiction'));
    $paper           = boolval($paper ?? request()->query('paper'));
    $search_title    = $search_title ?? request()->query('search_title');
    $wishlist        = boolval($wishlist ?? request()->query('wishlist'));

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Reading::SEARCH_ORDER_BY[0], Reading::SEARCH_ORDER_BY[1] ]);
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
                                                  'author|asc'           => 'author',
                                                  'title|asc'            => 'title',
                                                  'publication_year|asc' => 'year',
                                              ],
                                  )
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
                                    'list'  => new Reading()->listOptions(
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
                            <div class="control" style="max-width: 28rem;">
                                @include('admin.components.form-select', [
                                    'name'     => 'author',
                                    'value'    => $author,
                                    'list'     => new Reading()->listOptions(
                                        !empty($owner->is_root) ? [] : (!empty($owner) ? [ 'owner_id' => $owner->id ] : []),
                                        'author',
                                        'author',
                                        true,
                                        false,
                                        [ 'author', 'asc' ]
                                    ),
                                    'style'    => 'min-width: 15rem;'
                                ])
                            </div>
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('admin.components.form-checkbox', [
                                    'name'     => 'fiction',
                                    'value'    => 1,
                                    'checked'  => $fiction,
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>

                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('admin.components.form-checkbox', [
                                    'name'     => 'nonfiction',
                                    'value'    => 1,
                                    'checked'  => $nonfiction,
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('admin.components.form-checkbox', [
                                    'name'     => 'paper',
                                    'value'    => 1,
                                    'checked'  => $paper,
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>

                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('admin.components.form-checkbox', [
                                    'name'     => 'audio',
                                    'value'    => 1,
                                    'checked'  => $audio,
                                    'nohidden' => true,
                                ])
                            </div>
                        </div>

                        <div class="search-form-control">
                            <div class="container control" style="width: 8rem;">
                                @include('admin.components.form-checkbox', [
                                    'name'     => 'wishlist',
                                    'value'    => 1,
                                    'checked'  => $wishlist,
                                    'nohidden' => true,
                                ])
                            </div>
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
