@php
    use App\Models\Personal\Recipe;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Recipe::SEARCH_ORDER_BY[0], Recipe::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">

                        @if(isRootAdmin())

                            @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])

                        @endif

                        @if(!empty($owner))

                            @php
                                $recipes = new Recipe()->listOptions(
                                    [ 'owner_id' => $owner->id ],
                                    'id',
                                    'name',
                                    true,
                                    false,
                                    [ 'name', 'asc' ]
                                );

                                $recipeId = Request::get('recipe_id');
                                if (!array_key_exists($recipeId, $recipes)) {
                                    $recipeId = null;
                                }
                            @endphp

                            <?php /* @TODO: Need to handle deselect of other fields when a new select list option is chosen. */ ?>
                            @if(count($recipes) > 1)
                                <div class="control">
                                    @include('admin.components.form-select', [
                                        'name'     => 'recipe_id',
                                        'label'    => 'recipe',
                                        'value'    => $recipeId,
                                        'list'     => $recipes,
                                    ])
                                </div>
                            @endif
                        @endif

                    </div>

                    <div class="floating-div">
                        @include('admin.components.search-panel.controls.timestamp-created-at', [
                            'created_at_from' => $created_at_from,
                            'created_at_to'   => $created_at_to,
                        ])
                    </div>

                </div>

                <div class="has-text-right pr-2">
                    @include('admin.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    @include('admin.components.button-search', [
                        'id' =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
