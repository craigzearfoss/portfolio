@php
    use App\Models\Personal\Recipe;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $created_at_min = $created_at_min ?? request()->query('created_at-min');
    $created_at_max   = $created_at_max ?? request()->query('created_at-max');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ Recipe::SEARCH_ORDER_BY[0], Recipe::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">

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
                                    @include('user.components.form-select', [
                                        'name'     => 'recipe_id',
                                        'label'    => 'recipe',
                                        'value'    => $recipeId,
                                        'list'     => $recipes,
                                    ])
                                </div>
                            @endif
                        @endif

                    </div>

                </div>

                <div class="has-text-right pr-2">
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
