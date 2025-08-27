@extends('admin.layouts.default', [
    'title' => 'Dictionary Frameworks',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Frameworks' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Framework', 'url' => route('admin.dictionary.framework.create') ],
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
            <th>languages</th>
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
            <th>languages</th>
            <th class="text-nowrap">wiki page</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($dictionaryFrameworks as $dictionaryFramework)

            <tr>
                <td class="py-0">
                    {{ $dictionaryFramework->name }}
                </td>
                <td class="py-0">
                    {{ $dictionaryFramework->abbreviation }}
                </td>
                <td class="py-0">
                    {{ $dictionaryFramework->owner }}
                </td>
                <td class="py-0">
                    {{ implode(', ',  $dictionaryFramework->languages->pluck('name')->toArray()) }}
                </td>
                <td class="py-0 px-2">
                    @include('admin.components.link', [ 'url' => $dictionaryFramework->wiki_page, 'target' => '_blank' ])
                </td>
                <td class="white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.dictionary.framework.destroy', $dictionaryFramework->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary.framework.show', $dictionaryFramework->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary.framework.edit', $dictionaryFramework->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($dictionaryFramework->website))
                            <a title="website" class="button is-small px-1 py-0" href="{{ $dictionaryFramework->website }}"
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
                <td colspan="6">There are no dictionary frameworks.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $dictionaryFrameworks->links('vendor.pagination.bulma') !!}

@endsection
