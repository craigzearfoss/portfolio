@php
    use App\Models\Personal\Recipe;
    use App\Models\Personal\RecipeStep;
    use App\Models\System\Admin;

    // get variables
    $action          = $action ?? url()->current();
    $owner_id        = $owner->id ?? -1;
    $created_at_from = $created_at_from ?? request()->query('created_at_from');
    $created_at_to   = $created_at_to ?? request()->query('created_at_to');
    $recipe_id       = $recipe_id ?? request()->query('recipe_id');
    $recipe_name     = $recipe_name ?? request()->query('recipe_name');
    $summary         = $summary ?? request()->query('summary');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ RecipeStep::SEARCH_ORDER_BY[0], RecipeStep::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('user.components.search-sort-select', [
                        'sort' => $sort,
                        'list' => array_merge($isRootAdmin ? [ 'owner.username|asc' => 'owner' ] : [],
                                              [
                                                  'recipe_name|asc'     => 'recipe',
                                              ],
                                  )
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

                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'recipe_name',
                                'label'   => 'recipe',
                                'value'   => $recipe_name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('user.components.input', [
                                'name'    => 'summary',
                                'label'   => 'summary',
                                'value'   => $summary,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>


                </div>

            </div>

        </form>

    </div>

</div>
