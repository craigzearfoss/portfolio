<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">
        <form id="searchForm" action="{!! $action !!}" method="get">

            @if(isRootAdmin())

                <div class="control">
                    @include('admin.components.form-select', [
                        'name'     => 'owner_id',
                        'label'    => 'owner',
                        'value'    => !empty($owner->root) ? null : ($owner->id ?? null),
                        'list'     => \App\Models\System\Admin::listOptions(
                            [],
                            'id',
                            'username',
                            true,
                            false,
                            [ 'username', 'asc' ]
                        ),
                        'onchange' => "document.getElementById('searchForm').submit()"
                    ])
                </div>

            @endif

            @if(!empty($owner))

                @php
                    $recipes = \App\Models\Personal\Recipe::listOptions(
                        !empty($owner) ? [ 'owner_id' => $owner->id ] : [],
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
                        'onchange' => "document.getElementById('searchForm').submit()"
                    ])
                </div>
                @endif
            @endif

        </form>

    </div>

</div>
