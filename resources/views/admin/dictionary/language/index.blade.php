@extends('admin.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'href' => route('admin.dictionary.index') ],
        [ 'name' => 'Languages' ]
    ],
    'selectList' => View::make('admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.language.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions([], true, 'route', 'admin.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => isRootAdmin()
            ? [
                [ 'name' => '<i class="fa fa-plus"></i> Add New Language', 'href' => route('admin.dictionary.language.create') ]
              ]
            : [],
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

            @forelse ($languages as $language)

                <tr data-id="{{ $language->id }}">
                    <td data-field="name">
                        {{ $language->name }}
                    </td>
                    <td data-field="abbreviation">
                        {{ $language->abbreviation }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $language->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $language->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary.language.show', $language->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        @if(isRootAdmin())
                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.language.edit', $language->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>
                        @endif

                        @if (!empty($language->link))
                            <a title="{{ !empty($language->link_name) ? $language->link_name : 'link' }}"
                               class="button is-small px-1 py-0"
                               href="{{ $language->link }}"
                               target="_blank"
                            >
                                <i class="fa-solid fa-external-link"></i>{{-- link --}}
                            </a>
                        @else
                            <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>{{-- link --}}
                            </a>
                        @endif

                        @if (!empty($language->wikipedia))
                            <a title="Wikipedia page"
                               class="button is-small px-1 py-0"
                               href="{{ $language->wikipedia }}"
                               target="_blank"
                            >
                                <i class="fa-solid fa-file"></i>{{-- wikipedia --}}
                            </a>
                        @else
                            <a title="Wikipedia page" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-file"></i>{{-- wikipedia --}}
                            </a>
                        @endif

                        @if(isRootAdmin())
                            <form action="{{ route('admin.dictionary.language.destroy', $language->id) }}"
                                  method="POST"
                                  style="display:inline-flex"
                            >
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>{{-- delete --}}
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no languages.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $languages->links('vendor.pagination.bulma') !!}

    </div>

@endsection
