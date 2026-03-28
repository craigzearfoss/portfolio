@php
    use App\Models\Personal\Recipe;
    use App\Models\System\Admin;

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
                                @include('guest.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                            </div>
                        @endif
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
