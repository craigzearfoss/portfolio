@php
    use App\Enums\EnvTypes;
    use App\Models\Portfolio\Music;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $artist          = $artist ?? request()->query('artist');
    $catalog_number  = $catalog_number ?? request()->query('catalog_number');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');
    $name            = $name ?? request()->query('name');
    $search_label    = $search_label ?? request()->query('search_label');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Music::SEARCH_ORDER_BY[0], Music::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Music()->getSortOptions($sort, EnvTypes::GUEST),
                        'style' => [ 'width: 10rem !important', 'max-width: 10rem !important' ],
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
                            @include('guest.components.form-input', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'artist',
                                'value'   => $artist,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'search_label',
                                'label'   => 'label',
                                'value'   => $search_label,
                                'message' => $message ?? '',
                            ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'catalog_number',
                                'label'   => 'catalog number',
                                'value'   => $catalog_number,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>
