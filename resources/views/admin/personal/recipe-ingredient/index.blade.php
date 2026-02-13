@php
    $buttons = [];
    if (canCreate(\App\Enums\PermissionEntityTypes::RESOURCE, 'recipe-ingredient', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recipe Ingredient', 'href' => route('admin.personal.recipe-ingredient.create', $owner)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? ((!empty($recipeId) && !empty($recipeIngredient->recipe))
        ?  $recipeIngredient->recipe['name'] . ' Ingredients'
        : 'Recipe Ingredients'),
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => 'Ingredients' ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @include('admin.components.search-panel.recipe-child', [ 'action' => route('admin.personal.recipe-ingredient.index') ])

    <div class="card p-4">

        @if($pagination_top)
            {!! $recipeIngredients->links('vendor.pagination.bulma') !!}
        @endif

        <table class="table admin-table">
            <thead>
            <tr>
                @if(!empty($admin->root))
                    <th>owner</th>
                @endif
                @if(empty($recipe))
                    <th>recipe</th>
                @endif
                <th>name</th>
                <th>amount</th>
                <th>unit</th>
                <th>actions</th>
            </tr>
            </thead>

            @if(!empty($bottom_column_headings))
                <tfoot>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    @if(empty($recipe))
                        <th>recipe</th>
                    @endif
                    <th>name</th>
                    <th>amount</th>
                    <th>unit</th>
                    <th>actions</th>
                </tr>
                </tfoot>
            @endif

            <tbody>

            @forelse ($recipeIngredients as $recipeIngredient)

                <tr data-id="{{ $recipeIngredient->id }}">
                    @if($admin->root)
                        <td data-field="owner.username" style="white-space: nowrap;">
                            {{ $recipeIngredient->owner->username ?? '' }}
                        </td>
                    @endif
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
                    <td data-field="ingredient.name">
                        {!! $recipeIngredient->ingredient->name ?? '' !!}
                    </td>
                    <td data-field="amount">
                        {!! $recipeIngredient->amount !!}
                    </td>
                    <td data-field="unit.name">
                        {!! $recipeIngredient->unit->name ?? '' !!}
                    </td>
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead(\App\Enums\PermissionEntityTypes::RESOURCE, $recipeIngredient, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.personal.recipe-ingredient.show', [$owner, $recipeIngredient]),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate(\App\Enums\PermissionEntityTypes::RESOURCE, $recipeIngredient, $admin))
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

                            @if(canDelete(\App\Enums\PermissionEntityTypes::RESOURCE, $recipeIngredient, $admin))
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
                        $cols = $admin->root ? '5' : '4';
                        if (!empty($recipe)) $cols++;
                    @endphp
                    <td colspan="{{ $cols }}">There are no recipe ingredients.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $recipeIngredients->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
