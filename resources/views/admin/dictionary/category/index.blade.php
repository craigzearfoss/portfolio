@extends('admin.layouts.default', [
    'title' => 'Dictionary',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Categories' ]
    ],
    'selectList' => View::make('admin.components.form-select', [
            'name'     => '',
            'label'    => '',
            'value'    => route('admin.dictionary.category.index'),
            'list'     => \App\Models\Dictionary\DictionarySection::listOptions(true, 'route', 'admin.'),
            'onchange' => "window.location.href = this.options[this.selectedIndex].value;",
            'message'  => $message ?? '',
        ]),
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Category', 'url' => route('admin.dictionary.category.create') ],
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
                <th>abbrev</th>
                <th class="has-text-centered">sequence</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">read-only</th>
                <th class="has-text-centered">root</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($categories as $category)

                <tr>
                    <td class="py-0">
                        {{ $category->name }}
                    </td>
                    <td class="py-0">
                        {{ $category->abbreviation }}
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $category->public ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $category->readonly ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $category->root ])
                    </td>
                    <td class="py-0 has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $category->disabled ])
                    </td>
                    <td class="white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.dictionary.category.destroy', $category->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.category.show', $category->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.dictionary.category.edit', $category->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

                            @if (!empty($category->link))
                                <a title="link" class="button is-small px-1 py-0" href="{{ $category->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @else
                                <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link--}}
                                </a>
                            @endif

                            @if (!empty($category->wikipedia))
                                <a title="Wikipedia page" class="button is-small px-1 py-0" href="{{ $category->wikipedia }}"
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
                    <td colspan="7">There are no categories.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $categories->links('vendor.pagination.bulma') !!}

    </div>

@endsection
