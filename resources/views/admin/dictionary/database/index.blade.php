@php
    $buttons = [];
    if (canCreate('framework', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'href' => route('admin.dictionary.framework.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Dictionary',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Databases' ]
    ],
    'selectList'    => View::make('admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.database.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'admin.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
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
                <th>abbrev</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>abbrev</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($databases as $database)

                <tr data-id="{{ $database->id }}">
                    <td data-field="name">
                        {{ $database->name }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $database->abbreviation }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $database->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $database->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        @if(canRead($database))
                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.database.show', $database->id) }}">
                                <i class="fa-solid fa-list"></i>
                            </a>
                        @endif


                        @if(canUpdate($database))
                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.database.edit', $database->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        @endif

                        @if (!empty($database->link))
                            <a title="{{ !empty($database->link_name) ? $database->link_name : 'link' }}"
                               class="button is-small px-1 py-0"
                               href="{{ $database->link }}"
                               target="_blank"
                            >
                                <i class="fa-solid fa-external-link"></i>
                            </a>
                        @else
                            <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>
                            </a>
                        @endif

                        @if (!empty($database->wikipedia))
                            <a title="Wikipedia page"
                               class="button is-small px-1 py-0"
                               href="{{ $database->wikipedia }}"
                               target="_blank"
                            >
                                <i class="fa-solid fa-file"></i>
                            </a>
                        @else
                            <a title="Wikipedia page" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-file"></i>
                            </a>
                        @endif

                        @if(canDelete($database))
                            <form action="{{ route('admin.dictionary.database.destroy', $database->id) }}"
                                  method="POST"
                                  style="display:inline-flex"
                            >
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no databases.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $databases->links('vendor.pagination.bulma') !!}

    </div>

@endsection
