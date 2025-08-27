@extends('admin.layouts.default', [
    'title' => 'Dictionary Databases',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Databases' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Database', 'url' => route('admin.dictionary.database.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th>abbreviation</th>
            <th>owner</th>
            <th class="text-nowrap">wiki page</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th>abbreviation</th>
            <th>owner</th>
            <th class="text-nowrap">wiki page</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($dictionaryDatabases as $dictionaryDatabase)

            <tr>
                <td class="py-0">
                    {{ $dictionaryDatabase->name }}
                </td>
                <td class="py-0">
                    {{ $dictionaryDatabase->abbreviation }}
                </td>
                <td class="py-0">
                    {{ $dictionaryDatabase->owner }}
                </td>
                <td class="py-0 px-2">
                    @include('admin.components.link', [ 'url' => $dictionaryDatabase->wiki_page, 'target' => '_blank' ])
                </td>
                <td class="white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.dictionary.database.destroy', $dictionaryDatabase->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary.database.show', $dictionaryDatabase->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary.database.edit', $dictionaryDatabase->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($dictionaryDatabase->website))
                            <a title="website" class="button is-small px-1 py-0" href="{{ $dictionaryDatabase->website }}"
                               target="_blank">
                                <i class="fa-solid fa-external-link"></i>{{-- website--}}
                            </a>
                        @else
                            <a title="website" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>{{-- website--}}
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
                <td colspan="5">There are no dictionary databases.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $dictionaryDatabases->links('vendor.pagination.bulma') !!}

@endsection
