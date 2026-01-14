@php
    if (!empty($application)) {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
            [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
            [ 'name' => $recipe->name,     'href' => route('admin.personal.recipe.show', $recipe) ],
            [ 'name' => 'Steps' ],
        ];
    } else {
        $breadcrumbs = [
            [ 'name' => 'Home',            'href' => route('admin.index') ],
            [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
            [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
            [ 'name' => 'Recipes',         'href' => route('admin.personal.recipe.index') ],
        ];
    }

    $buttons = [];
    if (canCreate('recipe-step', getAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Step', 'href' => route('admin.personal.recipe-step.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => (!empty($recipe->name))
        ?  $recipe->name . ' Instructions'
        : 'Recipe Instructions',
    'breadcrumbs'   => $breadcrumbs,
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
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
                <th>step</th>
                <th>description</th>
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
                <th>step</th>
                <th>description</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($recipeSteps as $recipeStep)

                <tr data-id="{{ $recipeStep->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
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
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('admin.personal.recipe-step.destroy', $recipeStep->id) !!}" method="POST">

                            @if(canRead($recipeStep))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.personal.recipeStep.show', $recipeStep->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($recipeStep))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.personal.recipeStep.edit', $recipeStep->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if(canDelete($recipeStep))
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
                        $cols = isRootAdmin() ? '4' : '3';
                        if (!empty($recipeId)) {
                            $cols++;
                        }
                    @endphp
                    <td colspan="{{ $cols }}">There are no recipe steps.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $recipeSteps->links('vendor.pagination.bulma') !!}

    </div>

@endsection
