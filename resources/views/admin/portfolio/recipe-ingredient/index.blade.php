@extends('admin.layouts.default', [
    'title' => 'Recipe Ingredients',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Recipe Ingredients']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Ingredient', 'url' => route('admin.portfolio.recipe-ingredient.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th>description</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th>description</th>
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
                    <form action="{{ route('admin.portfolio.recipe-ingredient.destroy', $recipeIngredient->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.recipe-ingredient.show', $recipeIngredient->id) }}">
                            <i class="fa-solid fa-list"></i> {{-- Show --}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.recipe-ingredient.edit', $recipeIngredient->id) }}">
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
                <td colspan="3">There are no recipe ingredients.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $recipeIngredients->links('vendor.pagination.bulma') !!}

@endsection
