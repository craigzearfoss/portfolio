@extends('admin.layouts.default', [
    'title' => 'Dictionary Categories',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Dictionary',      'url' => route('admin.dictionary.index') ],
        [ 'name' => 'Categories' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Category', 'url' => route('admin.dictionary.category.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th class="text-nowrap">wiki page</th>
            <th>description</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th class="text-nowrap">wiki page</th>
            <th>description</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($dictionaryCategories as $dictionaryCategory)

            <tr>
                <td class="py-0">
                    {{ $dictionaryCategory->name }}
                </td>
                <td class="py-0 px-2">
                    @include('admin.components.link', [ 'url' => $dictionaryCategory->wiki_page, 'target' => '_blank' ])
                </td>
                <td class="py-0">
                    {{ $dictionaryCategory->description }}
                </td>
                <td class="white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.dictionary.category.destroy', $dictionaryCategory->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary.category.show', $dictionaryCategory->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary.category.edit', $dictionaryCategory->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

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
                <td colspan="4">There are no dictionary categories.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $dictionaryCategories->links('vendor.pagination.bulma') !!}

@endsection
