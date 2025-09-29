@extends('admin.layouts.default', [
    'title' => (!empty($recipeId) && !empty($recipeStep->recipe))
        ?  $recipeStep->recipe['name'] . ' Instructions'
        : 'Recipe Instructions',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard',           'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',                  'href' => route('admin.personal.index') ],
        [ 'name' => 'Recipes',                   'href' => route('admin.personal.recipe.index') ],
        [ 'name' => $recipeStep->recipe['name'], 'href' => route('admin.personal.recipe.show', $recipeStep->recipe) ],
        [ 'name' => 'Steps' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Step', 'url' => route('admin.personal.recipe-step.create') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                            {{ $recipeStep->owner['username'] ?? '' }}
                        </td>
                    @endif
                    @if(empty($recipeId))
                        <td data-field="recipe.name">
                            @if(!empty($recipeStep->recipe))
                                @include('admin.components.link', [
                                    'name' => $recipeStep->recipe['name'],
                                    'href' => route('admin.personal.recipe.show', $recipeStep->recipe)
                                ])
                            @endif
                        </td>
                    @endif
                    <td data-field="step" class="has-text-centered">
                        {{ $recipeStep->step }}
                    </td>
                    <td data-field="description">
                        {!! nl2br($recipeStep->description ?? '') !!}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.personal.recipe-step.destroy', $recipeStep->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.personal.recipe-step.show', $recipeStep->id) }}">
                                <i class="fa-solid fa-list"></i> {{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.personal.recipe-step.edit', $recipeStep->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                            </button>
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
