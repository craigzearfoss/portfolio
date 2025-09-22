@extends('admin.layouts.default', [
    'title' => 'Ingredients',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Ingredients' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Ingredient', 'url' => route('admin.portfolio.ingredient.create') ],
    ],
    'errorMessages'=> $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
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
                <th>name</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($ingredients as $ingredient)

                <tr>
                    <td class="py-0">
                        {{ $ingredient->name }}
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $ingredient->public ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $ingredient->readonly ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $ingredient->root ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $ingredient->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.ingredient.destroy', $ingredient->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.ingredient.show', $ingredient->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.ingredient.edit', $ingredient->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($ingredient->link))
                                <a title="{{ !empty($ingredient->link_name) ? $ingredient->link_name : 'link' }}" class="button is-small px-1 py-0" href="{{ $ingredient->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
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
                    <td colspan="6">There are no ingredients.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $ingredients->links('vendor.pagination.bulma') !!}

    </div>

@endsection
