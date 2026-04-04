@php
    use App\Models\Personal\Recipe;
    use App\Models\System\Admin;

    $action    = $action ?? url()->current();
    $owner_id  = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $recipe_id = $recipe_id ?? request()->query('recipe_id');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        @if($isRootAdmin)
                            <div class="search-form-control">
                                @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('admin.components.form-select', [
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
