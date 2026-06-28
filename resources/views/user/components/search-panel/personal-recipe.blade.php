@php
    use App\Enums\EnvTypes;
    use App\Models\Personal\Recipe;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    // get variables
    $action         = $action ?? url()->current();
    $author         = $author ?? request()->query('author');
    $created_at_max = $created_at_max ?? request()->query('created_at-max');
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $favorites      = $favorites ?? request()->query('favorites');
    $name           = $name ?? request()->query('name');
    $owner_id       = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $prep_time_max  = $prep_time_max ?? request()->query('prep_time-max');
    $total_time_max = $total_time_max ?? request()->query('total_time-max');
    $updated_at_max = $updated_at_max ?? request()->query('updated_at-max');
    $updated_at_min = $updated_at_min ?? request()->query('updated_at-min');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Recipe::SEARCH_ORDER_BY[0], Recipe::SEARCH_ORDER_BY[1] ]);
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
                        'list'  => new Recipe()->getSortOptions($sort),
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

                        <div class="search-form-control">
                            @include('user.components.form-input-with-icon', [
                                'name'    => 'name',
                                'value'   => $name,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.form-input', [
                                'name'    => 'author',
                                'value'   => $author,
                                'message' => $message ?? '',
                                'class'   => [ 'submit-search-on-enter-key' ],
                                'style'   => [ 'width: 12rem' ],
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.personal-recipe-type')
                        </div>

                        <div class="search-form-control">
                            @include('user.components.search-panel.controls.personal-recipe-meal')
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.form-input', [
                                'name'        => 'prep_time-max',
                                'label'       => 'max prep time',
                                'value'       => $prep_time_max,
                                'placeholder' => '(minutes)',
                                'message'     => $message ?? '',
                                'class'        => [ 'submit-search-on-enter-key' ],
                                'style'       => 'width: 5rem;',
                                'title'       => 'Maximum prep time in minutes.',
                            ])
                        </div>

                        <div class="search-form-control">
                            @include('user.components.form-input', [
                                'name'        => 'total_time_max',
                                'label'       => 'max total time',
                                'value'       => $total_time_max,
                                'placeholder' => '(minutes)',
                                'message'     => $message ?? '',
                                'style'       => 'width: 5rem;',
                                'class'       => [ 'submit-search-on-enter-key' ],
                                'title'       => 'Maximum total time in minutes.',
                            ])
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
                                'attributes' => [ 'data-resource' => 'personal.recipe' ]
                            ])
                        </div>

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
