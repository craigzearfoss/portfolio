@extends('admin.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Operating Systems' ]
    ],
    'selectList' => View::make('admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.operating-system.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true, 'route', 'admin.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Operating System', 'url' => route('admin.dictionary.operating-system.create') ],
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

            @forelse ($operatingSystems as $operatingSystem)

                <tr>
                    <td>
                        {{ $operatingSystem->name }}
                    </td>
                    <td>
                        {{ $operatingSystem->abbreviation }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $operatingSystem->public ])
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $operatingSystem->disabled ])
                    </td>
                    <td class="white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.dictionary.operating-system.destroy', $operatingSystem->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.operating-system.show', $operatingSystem->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.operating-system.edit', $operatingSystem->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($operatingSystem->link))
                                <a title="link" class="button is-small px-1 py-0" href="{{ $operatingSystem->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @else
                                <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @endif

                            @if (!empty($operatingSystem->wikipedia))
                                <a title="Wikipedia page" class="button is-small px-1 py-0" href="{{ $operatingSystem->wikipedia }}"
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
                    <td colspan="5">There are no operating systems.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $operatingSystems->links('vendor.pagination.bulma') !!}

    </div>

@endsection
