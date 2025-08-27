@extends('admin.layouts.default', [
    'title' => 'Dictionary Libraries',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Libraries']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Library', 'url' => route('admin.dictionary_library.create') ],
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

        @forelse ($dictionaryLibraries as $dictionaryLibrary)

            <tr>
                <td class="py-0">
                    {{ $dictionaryLibrary->name }}
                </td>
                <td class="py-0">
                    {{ $dictionaryLibrary->abbreviation }}
                </td>
                <td class="py-0">
                    {{ $dictionaryLibrary->owner }}
                </td>
                <td class="py-0 px-2">
                    @include('admin.components.link', [ 'url' => $dictionaryLibrary->wiki_page, 'target' => '_blank' ])
                </td>
                <td class="white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.dictionary_library.destroy', $dictionaryLibrary->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary_library.show', $dictionaryLibrary->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary_library.edit', $dictionaryLibrary->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($dictionaryLibrary->website))
                            <a title="website" class="button is-small px-1 py-0" href="{{ $dictionaryLibrary->website }}"
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
                <td colspan="5">There are no dictionary operating systems.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $dictionaryLibraries->links('vendor.pagination.bulma') !!}

@endsection
