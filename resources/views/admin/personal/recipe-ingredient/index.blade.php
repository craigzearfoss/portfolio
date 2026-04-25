@php
    use App\Models\Personal\RecipeIngredient;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Personal\RecipeIngredient';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? ((!empty($recipeId) && !empty($recipeIngredient->recipe))
        ?  $recipeIngredient->recipe['name'] . ' Ingredients'
        : 'Recipe Ingredients');
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => 'Ingredients' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(RecipeIngredient::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recipe Ingredient', 'href' => route('admin.personal.recipe-ingredient.create', $owner)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.personal-recipe-ingredient', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container" style="max-width: 70em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.personal.recipe-ingredient.export', request()->except([ 'page' ])),
                'filename' => 'recipe_ingredients_' . date("Y-m-d-His") . '.xlsx',
            ])

            @if($pagination_top)
                {!! $recipeIngredients->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"></p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        @if(empty($recipe))
                            <th>recipe</th>
                        @endif
                        <th class="has-text-centered">amount</th>
                        <th>unit</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        @if($isRootAdmin)
                            <th>owner</th>
                        @endif
                        <th>name</th>
                        @if(empty($recipe))
                            <th>recipe</th>
                        @endif
                        <th class="has-text-centered">amount</th>
                        <th>unit</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($recipeIngredients as $recipeIngredient)

                    <tr data-id="{{ $recipeIngredient->id }}">
                        @if($isRootAdmin)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $recipeIngredient->owner->username ?? '' }}
                            </td>
                        @endif
                        <td data-field="ingredient.name">
                            {!! $recipeIngredient->ingredient->name ?? '' !!}
                        </td>
                        @if(empty($recipe))
                            <td data-field="recipe.name">
                                @if(!empty($recipeIngredient->recipe))
                                    @include('admin.components.link', [
                                        'name' => $recipeIngredient->recipe->name,
                                        'href' => route('admin.personal.recipe.show', $recipeIngredient->recipe)
                                    ])
                                @endif
                            </td>
                        @endif
                        <td data-field="amount" class="has-text-centered">
                            {!! $recipeIngredient->amount !!}
                        </td>
                        <td data-field="unit.name">
                            {!! $recipeIngredient->unit->name ?? '' !!}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($recipeIngredient, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.personal.recipe-ingredient.show', [$owner, $recipeIngredient]),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($recipeIngredient, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.personal.recipe-ingredient.edit', [$owner, $recipeIngredient]),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($recipeIngredient->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($recipeIngredient->link_name) ? $recipeIngredient->link_name : 'link',
                                        'href'   => $recipeIngredient->link,
                                        'icon'   => 'fa-external-link',
                                        'target' => '_blank'
                                    ])
                                @else
                                    @include('admin.components.link-icon', [
                                        'title'    => 'link',
                                        'icon'     => 'fa-external-link',
                                        'disabled' => true
                                    ])
                                @endif

                                @if(canDelete($recipeIngredient, $admin))
                                    <form class="delete-resource"
                                          action="{!! route('admin.personal.recipe-ingredient.destroy', $recipeIngredient) !!}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        @php
                            $cols = $isRootAdmin ? '5' : '4';
                            if (!empty($recipe)) $cols++;
                        @endphp
                        <td colspan="{{ $cols }}">No recipe ingredients found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if($pagination_bottom)
                {!! $recipeIngredients->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
