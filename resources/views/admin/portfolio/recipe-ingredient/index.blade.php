@extends('admin.layouts.default', [
    'title' => 'Recipe Ingredients',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Recipes',         'url' => route('admin.portfolio.recipe.index') ],
        [ 'name' => 'Ingredients' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe Ingredient', 'url' => route('admin.portfolio.recipe-ingredient.create') ],
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
                <th>name</th>
                <th>amount</th>
                <th>unit</th>
                <th>qualifier</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>name</th>
                <th>amount</th>
                <th>unit</th>
                <th>qualifier</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($recipeIngredients as $recipeIngredient)

                <tr data-id="{{ $recipeIngredient->id }}">
                    @if(isRootAdmin())
                        <td data-field="admin.username">
                            @if(!empty($recipeIngredient->admin))
                                @include('admin.components.link', [
                                    'name' => $recipeIngredient->admin['username'],
                                    'url'  => route('admin.admin.show', $recipeIngredient->admin['id'])
                                ])
                            @endif
                        </td>
                    @endif
                    <td data-field="ingredient.name">
                        {{ $recipeIngredient->ingredient['name'] ?? '' }}
                    </td>
                    <td data-field="amount">
                        {{ $recipeIngredient->amount }}
                    </td>
                    <td data-field="unit.name">
                        {{ $recipeIngredient->unit['name'] ?? ''}}
                    </td>
                    <td data-field="qualifier">
                        {{ $recipeIngredient->qualifier ?? '' }}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.recipe-ingredient.destroy', $recipeIngredient->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.recipe-ingredient.show', $recipeIngredient->id) }}">
                                <i class="fa-solid fa-list"></i> {{-- show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.recipe-ingredient.edit', $recipeIngredient->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            @if (!empty($recipeIngredient->link))
                                <a title="link" class="button is-small px-1 py-0"
                                   href="{{ !empty($recipeIngredient->link_name) ? $recipeIngredient->link_name : 'link' }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @else
                                <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '6' : '5' }}">There are no recipe ingredients.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $recipeIngredients->links('vendor.pagination.bulma') !!}

    </div>

@endsection
