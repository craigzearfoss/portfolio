@php
    use App\Models\Personal\Recipe;
    use App\Models\System\Admin;

    $owner_id = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">
        <form id="searchForm" action="{!! $action !!}" method="get">

            @if(isRootAdmin())

                @include('user.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])

            @endif

            @if(!empty($owner))

                @php
                    $recipes = new Recipe()->listOptions([ 'owner_id' => $owner->id ], 'id', 'name', true, false, [ 'name', 'asc' ]);
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
                            'onchange' => "document.getElementById('searchForm').submit()"
                        ])
                    </div>
                @endif
            @endif

        </form>

    </div>

</div>
