@extends('admin.layouts.default', [
    'title' => 'Recipes',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Recipes' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Recipe', 'url' => route('admin.portfolio.recipe.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th class="text-center">professional</th>
                <th class="text-center">personal</th>
                <th class="text-center">sequence</th>
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
                <th class="text-center">professional</th>
                <th class="text-center">personal</th>
                <th class="text-center">sequence</th>
                <th class="text-center">public</th>
                <th class="text-center">read-only</th>
                <th class="text-center">root</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($recipes as $recipe)

                <tr>
                    <td class="py-0">
                        {{ $recipe->name }}
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $recipe->professional ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $recipe->personal ])
                    </td>
                    <td class="py-0 text-center">
                        {{ $recipe->sequence }}
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $recipe->public ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $recipe->readonly ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $recipe->root ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $recipe->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.recipe.destroy', $recipe->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.recipe.show', $recipe->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.recipe.edit', $recipe->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($recipe->link))
                                <a title="link" class="button is-small px-1 py-0" href="{{ $recipe->link }}"
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
                    <td colspan="9">There are no recipes.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $recipes->links('vendor.pagination.bulma') !!}

    </div>

@endsection
