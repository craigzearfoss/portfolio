@php
    use App\Enums\PermissionEntityTypes;

    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
            [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
            [ 'name' => $recipe->name,     'href' => route('admin.personal.recipe.show', $recipe) ],
            [ 'name' => 'Steps' ],
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('guest.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
            [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        ];
    }

    $buttons = [];
    if (canCreate(PermissionEntityTypes::RESOURCE, 'recipe-step', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New Recipe Step', 'href' => route('admin.personal.recipe-step.create', $owner)])->render();
    }
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? (!empty($recipe->name) ?  $recipe->name . ' Instructions' : 'Recipe Instructions'),
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @include('admin.components.search-panel.recipe-child', [ 'action' => route('admin.personal.recipe-step.index') ])

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @if($pagination_top)
                {!! $recipeSteps->links('vendor.pagination.bulma') !!}
            @endif

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">
                <thead>
                <tr>
                    @if(!empty($admin->root))
                        <th>owner</th>
                    @endif
                    @if(empty($recipeId))
                        <th>recipe</th>
                    @endif
                    <th>step</th>
                    <th>description</th>
                    <th>actions</th>
                </tr>
                </thead>

                @if(!empty($bottom_column_headings))
                    <tfoot>
                    <tr>
                        @if(!empty($admin->root))
                            <th>owner</th>
                        @endif
                        @if(empty($recipeId))
                            <th>recipe</th>
                        @endif
                        <th>step</th>
                        <th>description</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($recipeSteps as $recipeStep)

                    <tr data-id="{{ $recipeStep->id }}">
                        @if($admin->root)
                            <td data-field="owner.username" style="white-space: nowrap;">
                                {{ $recipeStep->owner->username ?? '' }}
                            </td>
                        @endif
                        @if(empty($recipeId))
                            <td data-field="recipe.name">
                                @if(!empty($recipeStep->recipe))
                                    @include('admin.components.link', [
                                        'name' => $recipeStep->recipe->name ?? '',
                                        'href' => route('admin.personal.recipe.show', $recipeStep->recipe)
                                    ])
                                @endif
                            </td>
                        @endif
                        <td data-field="step" class="has-text-centered">
                            {!! $recipeStep->step !!}
                        </td>
                        <td data-field="description">
                            {!! $recipeStep->description !!}
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead(PermissionEntityTypes::RESOURCE, $recipeStep, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.personal.recipe-step.show', $recipeStep->id),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate(PermissionEntityTypes::RESOURCE, $recipeStep, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.personal.recipe-step.edit', $recipeStep->id),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if(canDelete(PermissionEntityTypes::RESOURCE, $recipeStep, $admin))
                                    <form class="delete-resource" action="{!! route('admin.personal.recipe-step.destroy', $recipeStep) !!}" method="POST">
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
                            $cols = $admin->root ? '4' : '3';
                            if (!empty($recipeId)) $cols++;
                        @endphp
                        <td colspan="{{ $cols }}">There are no recipe steps.</td>
                    </tr>

                @endforelse

                </tbody>
            </table>

            @if($pagination_bottom)
                {!! $recipeSteps->links('vendor.pagination.bulma') !!}
            @endif

        </div>
    </div>

@endsection
