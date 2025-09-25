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
                    <th>admin</th>
                @endif
                <th>name</th>
                <th class="has-text-centered">type</th>
                <th class="has-text-centered">meal</th>
                <th class="has-text-centered">featured</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>admin</th>
                @endif
                <th>name</th>
                <th class="has-text-centered">type</th>
                <th class="has-text-centered">meal</th>
                <th class="has-text-centered">featured</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($recipes as $recipe)

                <tr data-id="{{ $recipe->id }}">
                    @if(isRootAdmin())
                        <td>
                            @if(!empty($recipe->admin))
                                @include('admin.components.link', [
                                    'name' => $recipe->admin['username'],
                                    'url'  => route('admin.admin.show', $recipe->admin['id'])
                                ])
                            @endif
                        </td>
                    @endif
                    <td>
                        {{ $recipe->name }}
                    </td>
                    <td>
                        {{ implode(', ', $recipe->types()) }}
                    </td>
                    <td>
                        {{ implode(', ', $recipe->meals()) }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recipe->featured ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recipe->public ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $recipe->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.recipe.destroy', $recipe->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.recipe.show', $recipe->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.recipe.edit', $recipe->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @if (!empty($recipe->link))
                                <a title="{{ !empty($recipe->link_name) ? $recipe->$project : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $recipe->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- Delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '8' : '7' }}">There are no recipes.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $recipes->links('vendor.pagination.bulma') !!}

    </div>

@endsection
