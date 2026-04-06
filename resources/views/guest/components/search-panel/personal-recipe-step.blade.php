@php
    use App\Models\Personal\Recipe;
    use App\Models\Personal\RecipeStep;
    use App\Models\System\Admin;

    // get variables
    $action      = $action ?? url()->current();
    $owner_id    = $owner->id ?? -1;
    $recipe_id   = $recipe_id ?? request()->query('recipe_id');
    $recipe_name = $recipe_name ?? request()->query('recipe_name');
    $summary     = $summary ?? request()->query('summary');

    // set sort order
    $sort = $sort ?? request()->query('sort') ?? implode('|', [ RecipeStep::SEARCH_ORDER_BY[0], RecipeStep::SEARCH_ORDER_BY[1] ]);
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="search-panel-controls">

                    @include('guest.components.search-sort-select', [
                        'sort' => $sort,
                        'list' => array_merge($isRootAdmin ? [ 'owner.username|asc' => 'owner' ] : [],
                                              [
                                                  'recipe_name|asc'     => 'recipe',
                                              ],
                                  )
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
                            @include('guest.components.input-basic', [
                                'name'    => 'recipe_name',
                                'label'   => 'recipe',
                                'value'   => $recipe_name,
                                'message' => $message ?? '',
                            ])
                        </div>

                    </div>
                    <div class="floating-div">

                        <div class="search-form-control">
                            @include('guest.components.input-basic', [
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
