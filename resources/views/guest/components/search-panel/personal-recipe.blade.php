@php
    use App\Enums\EnvTypes;
    use App\Models\Personal\Recipe;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $author          = $author ?? request()->query('author');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');
    $name            = $name ?? request()->query('name');
    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $prep_time       = $prep_time ?? request()->query('prep_time');
    $total_time      = $total_time ?? request()->query('total_time');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Recipe::SEARCH_ORDER_BY[0], Recipe::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort'  => $sort,
                        'list'  => new Recipe()->getSortOptions($sort, EnvTypes::ADMIN, $isRootAdmin),
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

                        @if($isRootAdmin)
                            <div class="search-form-control">
                                @include('guest.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif

                        <div class="search-form-control">
                            @include('guest.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'author',
                                'value'   => $author,
                                'message' => $message ?? '',
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.personal-recipe-type')
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.search-panel.controls.personal-recipe-meal')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'prep_time',
                                'label'   => 'prep time',
                                'value'   => $prep_time,
                                'message' => $message ?? '',
                                'style'   => 'width: 5rem;',
                                'title'   => 'Minimum prep time in minutes.',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('guest.components.form-input', [
                                'name'    => 'total_time',
                                'label'   => 'total time',
                                'value'   => $total_time,
                                'message' => $message ?? '',
                                'style'   => 'width: 5rem;',
                                'title'   => 'Minimum total time in minutes.',
                            ])
                        </div>

                    </div>

                    @if($isRootAdmin)
                        <div class="floating-div">

                            @include('guest.components.search-panel.controls.timestamp-created-at', [
                                'created_at-min' => $created_at_min,
                                'created_at-max' => $created_at_max,
                            ])

                            @include('guest.components.search-panel.controls.timestamp-updated-at', [
                                'updated_at-min' => $updated_at_min,
                                'updated_at-max' => $updated_at_max,
                            ])

                        </div>
                    @endif

                </div>

            </div>

        </form>

    </div>

</div>
