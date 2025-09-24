@extends('admin.layouts.default', [
    'title' => (!empty($recipe) ? $recipe->name : 'Recipe') . ' instructions',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard',           'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',                 'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Recipes',                   'url' => route('admin.portfolio.recipe.index') ],
        [ 'name' => $recipeStep->recipe['name'], 'url' => route('admin.portfolio.recipe.show', $recipeStep->recipe) ],
        [ 'name' => 'Steps' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Step', 'url' => route('admin.portfolio.recipe-step.create') ],
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
                @if(empty($recipe))
                    <th>recipe</th>
                @endif
                <th>step</th>
                <th>description</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(empty($recipe))
                    <th>recipe</th>
                @endif
                <th>step</th>
                <th>description</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($recipeSteps as $recipeStep)

                <tr>
                    @if(empty($recipe))
                        <td class="py-0 text-nowrap">
                            @include('admin.components.link', [
                                'url'  => route('admin.portfolio.recipe.show', $recipeStep->recipe),
                                'name' => $recipeStep->recipe['name']
                            ])
                        </td>
                    @endif
                    <td>
                        {{ $recipeStep->step }}
                    </td>
                    <td>
                        {!! nl2br($recipeStep->description ?? '') !!}
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recipeStep->public ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recipeStep->readonly ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recipeStep->root ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recipeStep->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.recipe-step.destroy', $recipeStep->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.recipe-step.show', $recipeStep->id) }}">
                                <i class="fa-solid fa-list"></i> {{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.recipe-step.edit', $recipeStep->id) }}">
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
                    <td colspan="{{ empty($recipe) ? '8' : '9' }}">There are no recipe steps.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $recipeSteps->links('vendor.pagination.bulma') !!}

    </div>

@endsection
