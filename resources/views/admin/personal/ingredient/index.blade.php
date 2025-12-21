@php
    $buttons = [];
    if (canCreate('ingredient', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Ingredient', 'href' => route('admin.personal.ingredient.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Ingredients',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Personal',        'href' => route('admin.personal.index') ],
        [ 'name' => 'Ingredients' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($ingredients as $ingredient)

                <tr data-id="{{ $ingredient->id }}">
                    <td data-field="name">
                        {{ $ingredient->name }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $ingredient->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $ingredient->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.personal.ingredient.destroy', $ingredient->id) }}" method="POST">

                            @if(canRead($ingredient))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.personal.ingredient.show', $ingredient->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($ingredient))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.personal.ingredient.edit', $ingredient->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($ingredient->link))
                                <a title="{{ !empty($ingredient->link_name) ? $ingredient->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $ingredient->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($ingredient))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">There are no ingredients.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $ingredients->links('vendor.pagination.bulma') !!}

    </div>

@endsection
