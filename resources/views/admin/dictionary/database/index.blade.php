@extends('admin.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Databases' ]
    ],
    'selectList' => View::make('admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.database.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true, 'route', 'admin.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'url' => route('admin.dictionary.database.create') ],
    ],
    'errors'  => $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>abbrev</th>
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
                <th>abbrev</th>
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

            @forelse ($databases as $database)

                <tr>
                    <td class="py-0">
                        {{ $database->name }}
                    </td>
                    <td class="py-0">
                        {{ $database->abbreviation }}
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->public ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->readonly ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->root ])
                    </td>
                    <td class="py-0 text-center">
                        @include('admin.components.checkmark', [ 'checked' => $database->disabled ])
                    </td>
                    <td class="white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.dictionary.database.destroy', $database->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.database.show', $database->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.database.edit', $database->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($database->link))
                                <a title="link" class="button is-small px-1 py-0" href="{{ $database->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @else
                                <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @endif

                            @if (!empty($database->wikipedia))
                                <a title="Wikipedia page" class="button is-small px-1 py-0" href="{{ $database->wikipedia }}"
                                   target="_blank">
                                    <i class="fa-solid fa-wikipedia-w"></i>{{-- wikipedia--}}
                                </a>
                            @else
                                <a title="Wikipedia page" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-wikipedia-w"></i>{{-- wikipedia--}}
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
                    <td colspan="7">There are no databases.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $databases->links('vendor.pagination.bulma') !!}

    </div>

@endsection
