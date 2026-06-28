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
        [ 'name' => 'Home',                    'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ]
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins', 'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Personal',   'href' => route('admin.personal.index') ];
    $breadcrumbs[] = [ 'name' => 'Recipes',    'href' => route('admin.personal.recipe.index') ];
    $breadcrumbs[] = [ 'name' => 'Ingredients' ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(RecipeIngredient::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Recipe Ingredient',
                                                                  'href' => route('admin.personal.recipe-ingredient.create', $isRootAdmin && !empty($owner) ? [ 'owner_id' => $owner->id ] : [])
                                                                ])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.personal-recipe-ingredient', [ 'owner_id' => $isRootAdmin ? null : $owner->id ])

    <div class="floating-div-container">

        <div class="show-container card floating-div" style="max-width: 80em !important;">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.personal.recipe-ingredient.export', request()->except([ 'page' ])),
                'filename' => 'recipe_ingredients_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ number_format($recipeIngredients->total()) }} {{ ($recipeIngredients->total() === 1) ? 'recipe ingredient' : 'recipe ingredients' }} found.</i></p>

            @if (!empty($pagination_top))
                {!! $recipeIngredients->links('vendor.pagination.bulma') !!}
            @endif

            <p class="admin-table-caption"><span class="sample-color-box-light-gray"></span> indicates the recipe ingredient is disabled.</p>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @php
                    $labelElems = $top_column_headings ?? false ? [ 'thead' ] : [];
                    if ($bottom_column_headings ?? false) $labelElems[] = 'tfoot';
                @endphp

                @foreach ($labelElems as $labelElem)

                    <{{ $labelElem }}>
                    <tr>
                        @if ($isRootAdmin)
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'id',
                                    'sort'  => 'id|asc',
                                ])
                            </th>
                            <th>
                                @include('guest.components.column-heading', [
                                    'class' => $className,
                                    'name'  => 'owner',
                                    'sort'  => 'owner_username|asc',
                                ])
                            </th>
                        @endif
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'name',
                                'sort'  => 'ingredient_name|asc',
                            ])
                        </th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'recipe',
                                'sort'  => 'recipe_name|asc',
                            ])
                        </th>
                        <th>amount</th>
                        <th>
                            @include('guest.components.column-heading', [
                                'class' => $className,
                                'name'  => 'unit',
                                'sort'  => 'unit_name|asc',
                            ])
                        </th>
                        <th>actions</th>
                    </tr>
                    </{{ $labelElem }}>

                @endforeach

                <tbody>

                @forelse ($recipeIngredients as $recipeIngredient)

                    <tr data-id="{{ $recipeIngredient->id }}" {!! $recipeIngredient->is_disabled ? 'class="disabled-text"' : '' !!}>
                        @if ($isRootAdmin)
                            <td data-field="id">
                                {{ $recipeIngredient->id }}
                            </td>
                            <td data-field="owner.username" style="white-space: nowrap;">
                                @include('admin.components.link', [
                                    'name'  => $recipeIngredient->owner->username,
                                    'href'  => route('admin.system.admin.show', $recipeIngredient->owner),
                                    'class' => $recipeIngredient->is_disabled ? [ 'disabled-text' ] : []
                                ])
                            </td>
                        @endif
                        <td data-field="ingredient.name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name'  => $recipeIngredient->ingredient->name,
                                'href'  => route('admin.personal.ingredient.show', $recipeIngredient->ingredient),
                                'class' => $recipeIngredient->is_disabled ? [ 'disabled-text' ] : []
                            ])
                            @include('admin.components.link-icon', [
                               'title'      => 'add to favorites',
                               'icon'       => 'fa-heart',
                               'border'     => false,
                               'target'     => '_blank',
                               'class'      => 'add-to-favorites',
                               'attributes' => [ 'data-resource' => 'personal.recipe_ingredient', 'data-id' => $recipeIngredient->id ]
                           ])
                        </td>
                        <td data-field="recipe.name" style="white-space: nowrap;">
                            @include('admin.components.link', [
                                'name'  => $recipeIngredient->recipe->name . (!empty($recipeIngredient->recipe->featured) ? '<span class="featured-splat">*</span>' : ''),
                                'href'  => route('admin.personal.recipe.show', $recipeIngredient->recipe),
                                'class' => $recipeIngredient->is_disabled ? [ 'disabled-text' ] : []
                            ])
                        </td>
                        <td data-field="amount" class="has-text-centered">
                            {!! htmlspecialchars($recipeIngredient->amount) !!}
                        </td>
                        <td data-field="unit.name">
                            {!! $recipeIngredient->unit->name ?? '' !!}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if (canRead($recipeIngredient, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.personal.recipe-ingredient.show', ownerParams($recipeIngredient, request()->input('owner_id'), $admin)),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if (canUpdate($recipeIngredient, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.personal.recipe-ingredient.edit', ownerParams($recipeIngredient, request()->input('owner_id'), $admin)),
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

                                @if (canDelete($recipeIngredient, $admin))
                                    <form class="delete-resource" action="{!! route('admin.personal.recipe-ingredient.destroy', $recipeIngredient) !!}" method="POST">
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
                            $cols = $isRootAdmin ? '6' : '4';
                            if (!empty($recipe)) $cols++;
                        @endphp
                        <td colspan="{{ $cols }}">No recipe ingredients found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if (!empty($pagination_bottom))
                {!! $recipeIngredients->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
