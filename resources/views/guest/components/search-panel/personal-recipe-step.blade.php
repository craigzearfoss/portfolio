@php
    use App\Models\Personal\Recipe;
    use App\Models\Personal\RecipeStep;
    use App\Models\System\Admin;

    // get variables
    $action    = $action ?? url()->current();
    $owner_id  = $owner->id ?? -1;
    $recipe_id = $recipe_id ?? request()->query('recipe_id');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ RecipeStep::SEARCH_ORDER_BY[0], RecipeStep::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('guest.components.form-select', [
                                    'name'     => 'recipe_id',
                                    'label'    => 'recipe',
                                    'value'    => $recipe_id,
                                    'list'     => new Recipe()->listOptions(
                                        !empty($owner->is_root) ? [] : (!empty($owner_id) ? [ 'owner_id' => $owner_id ] : []),
                                        'id',
                                        'name',
                                        true,
                                        false,
                                        [ 'name', 'asc' ]
                                    ),
                                    'style'    => 'min-width: 20rem;'
                                ])
                            </div>
                        </div>
                    </div>

                </div>

                <div class="has-text-right pr-2">
                    @include('guest.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    @include('guest.components.button-search', [
                        'id' =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
