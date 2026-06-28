@php
    use App\Enums\EnvTypes;
    use App\Models\Personal\Reading;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $audio          = boolval($audio ?? request()->query('audio'));
    $author         = $author ?? request()->query('author');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $favorites      = $favorites ?? request()->query('favorites');
    $fiction        = boolval($fiction ?? request()->query('fiction'));
    $nonfiction     = boolval($nonfiction ?? request()->query('nonfiction'));
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $paper          = boolval($paper ?? request()->query('paper'));
    $search_title   = $search_title ?? request()->query('title');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');
    $wishlist       = boolval($wishlist ?? request()->query('wishlist'));

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Reading::SEARCH_ORDER_BY[0], Reading::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}"
              class="search-form"
              method="get"
        >

            <div>

                <div class="search-panel-header">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Reading()->getSortOptions($sort),
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

                <div class="search-panel-body floating-div-container">

                    <?php /*
                    @if ($isRootAdmin)
                        <div class="floating-div">
                            <div class="search-form-control">
                                @include('user.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        </div>
                    @endif
                    */ ?>

                    <div class="floating-div">


                        <?php /*
                        // there are too many publications for a select list
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('user.components.form-select', [
                                    'name'  => 'title',
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
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'title',
                                'label'   => 'title',
                                'value'   => $search_title,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => [ 'width: 16rem' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('user.components.form-select', [
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
                                    'style'    => [ 'min-width: 15rem', 'max-width: 16rem' ]
                                ])
                            </div>
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="control" style="max-width: 28rem;">
                            @include('user.components.form-checkbox', [
                                'id'         => 'favoritesCheckBox',
                                'name'       => 'favorites',
                                'value'      => 1,
                                'checked'    => $favorites,
                                'nohidden'   => true,
                                'class'      => [ 'search-favorites' ],
                                'attributes' => [ 'data-resource' => 'personal.reading' ]
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        @include('user.components.form-checkbox', [
                            'name'     => 'fiction',
                            'value'    => 1,
                            'checked'  => $fiction,
                            'nohidden' => true,
                        ])

                        @include('user.components.form-checkbox', [
                            'name'     => 'nonfiction',
                            'value'    => 1,
                            'checked'  => $nonfiction,
                            'nohidden' => true,
                        ])

                    </div>
                    <div class="floating-div">

                        @include('user.components.form-checkbox', [
                            'name'     => 'paper',
                            'value'    => 1,
                            'checked'  => $paper,
                            'nohidden' => true,
                        ])

                        @include('user.components.form-checkbox', [
                            'name'     => 'audio',
                            'value'    => 1,
                            'checked'  => $audio,
                            'nohidden' => true,
                        ])

                        @include('user.components.form-checkbox', [
                            'name'     => 'wishlist',
                            'value'    => 1,
                            'checked'  => $wishlist,
                            'nohidden' => true,
                        ])

                    </div>

                    <?php /*
                    @if ($isRootAdmin)
                        <div class="floating-div">

                            @include('user.components.search-panel.controls.timestamp-created-at', [
                                'created_at-min' => $created_at_min,
                                'created_at-max' => $created_at_max,
                            ])

                            @include('user.components.search-panel.controls.timestamp-updated-at', [
                                'updated_at-min' => $updated_at_min,
                                'updated_at-max' => $updated_at_max,
                            ])

                        </div>
                    @endif
                    */ ?>

                </div>

            </div>

        </form>

    </div>

</div>
