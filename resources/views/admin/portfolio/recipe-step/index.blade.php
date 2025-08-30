@extends('admin.layouts.default', [
    'title' => 'Recipe Ingredients',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Recipes',         'url' => route('admin.portfolio.recipe.index') ],
        [ 'name' => 'Ingredients' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Ingredient', 'url' => route('admin.portfolio.recipe-step.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th class="text-center">public</th>
            <th class="text-center">read-only</th>
            <th class="text-center">root</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th class="text-center">public</th>
            <th class="text-center">read-only</th>
            <th class="text-center">root</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($recipeIngredients as $recipeIngredient)

            <tr>
                <td>
                    {{ $recipeIngredient->name }}
                </td>
                <td>
                    {{ $recipeIngredient->description }}
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.portfolio.recipe-step.destroy', $recipeIngredient->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.recipe-step.show', $recipeIngredient->id) }}">
                            <i class="fa-solid fa-list"></i> {{-- Show --}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.recipe-step.edit', $recipeIngredient->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($academy->link))
                            <a title="link" class="button is-small px-1 py-0" href="{{ $academy->link }}"
                               target="_blank">
                                <i class="fa-solid fa-external-link"></i>{{-- link--}}
                            </a>
                        @else
                            <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>{{-- link--}}
                            </a>
                        @endif

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
                <td colspan="6">There are no recipe ingredients.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $recipeIngredients->links('vendor.pagination.bulma') !!}

@endsection
