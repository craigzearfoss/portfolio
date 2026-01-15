@php
    $buttons = [];
    if (canCreate('recipe-ingredient', loggedInAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Ingredient', 'href' => route('admin.personal.recipe-ingredient.create', $admin) ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? ((!empty($recipeId) && !empty($recipeIngredient->recipe))
        ?  $recipeIngredient->recipe['name'] . ' Ingredients'
        : 'Recipe Ingredients'),
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        [ 'name' => 'Ingredients' ],
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'currentRouteName' => $currentRouteName,
    'loggedInAdmin'    => $loggedInAdmin,
    'loggedInUser'     => $loggedInUser,
    'admin'            => $admin,
    'user'             => $user
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                @if(empty($recipeId))
                    <th>recipe</th>
                @endif
                <th>name</th>
                <th>amount</th>
                <th>unit</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                @if(empty($recipeId))
                    <th>recipe</th>
                @endif
                <th>name</th>
                <th>amount</th>
                <th>unit</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($recipeIngredients as $recipeIngredient)

                <tr data-id="{{ $recipeIngredient->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $recipeIngredient->owner->username ?? '' }}
                        </td>
                    @endif
                    @if(empty($recipeId))
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
                        {!! $recipeIngredient->unit->name ?? '') !!}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.personal.recipe-ingredient.destroy', [$admin, $recipeIngredient->id]) !!}" method="POST">

                            @if(canRead($recipeIngredient))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.personal.recipe-ingredient.show', [$admin, $recipeIngredient->id]),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($recipeIngredient))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.personal.recipe-ingredient.edit', [$admin, $recipeIngredient->id]),
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

                            @if(canDelete($recipeIngredient))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    @php
                    $cols = isRootAdmin() ? '5' : '4';
                    if (!empty($recipeId)) {
                        $cols++;
                    }
                    @endphp
                    <td colspan="{{ $cols }}">There are no recipe ingredients.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $recipeIngredients->links('vendor.pagination.bulma') !!}

    </div>

@endsection
