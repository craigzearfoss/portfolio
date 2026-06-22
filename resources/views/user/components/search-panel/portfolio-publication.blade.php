@php
    use App\Enums\EnvTypes;
    use App\Models\Portfolio\Publication;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin = $admin ?? null;

    // get variables
    $action           = $action ?? url()->current();
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');
    $created_at_min   = $created_at_min ?? request()->query('created_at-min');
    $favorites        = $favorites ?? request()->query('favorites');
    $publication_name = $publication_name ?? request()->query('publication_name');
    $owner_id         = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $publisher        = $publisher ?? request()->query('publisher');
    $search_title     = $search_title ?? request()->query('search_title');
    $updated_at_max   = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min   = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Publication::SEARCH_ORDER_BY[0], Publication::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Publication()->getSortOptions($sort, $envTypes::USER),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ],
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

                        <?php /*
                        // there are too many publications for a select list
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('user.components.form-select', [
                                    'name'  => 'title',
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
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'title',
                                'label'   => 'title',
                                'value'   => $search_title,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'publication_name',
                                'label'   => 'publication',
                                'value'   => $publication_name,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'publisher',
                                'value'   => $publisher,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem'],
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
