@extends('admin.layouts.default', [
    'title' => 'Dictionary Stacks',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Stacks']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Stack', 'url' => route('admin.dictionary_stack.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>Name</th>
            <th class="px-2">Servers</th>
            <th class="px-2"><abbr title="Operating System">OS</abbr></th>
            <th class="px-2">Frameworks</th>
            <th class="px-2">Languages</th>
            <th class="px-2">Databases</th>
            <th class="px-2">Actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th class="px-2">servers</th>
            <th class="px-2"><abbr title="operating system">OS</abbr></th>
            <th class="px-2">frameworks</th>
            <th class="px-2">languages</th>
            <th class="px-2">databases</th>
            <th class="px-2">website</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($dictionaryStacks as $dictionaryStack)

            <tr>
                <td class="is-1 py-0">{{ $dictionaryStack->name }}</td>
                <td class="is-2 py-0 px-2">
                    {{ implode(', ',  $dictionaryStack->servers->pluck('name')->toArray()) }}
                </td>
                <td class="is-2 py-0 px-2">
                    {{ implode(', ',  $dictionaryStack->operating_systems->pluck('name')->toArray()) }}
                </td>
                <td class="is-2 py-0 px-2">
                    {{ implode(', ',  $dictionaryStack->frameworks->pluck('name')->toArray()) }}
                </td>
                <td class="is-2 py-0 px-2">
                    {{ implode(', ',  $dictionaryStack->languages->pluck('name')->toArray()) }}
                </td>
                <td class="is-2 py-0 px-2">
                    {{ implode(', ',  $dictionaryStack->databases->pluck('name')->toArray()) }}
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.dictionary_stack.destroy', $dictionaryStack->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary_stack.show', $dictionaryStack->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.dictionary_stack.edit', $dictionaryStack->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($dictionaryStack->website))
                            <a title="website" class="button is-small px-1 py-0" href="{{ $dictionaryStack->website }}"
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
                <td colspan="7">There are no dictionary stacks.</td>
            </tr>

        @endforelse

        </tbody>
    </table>


    {!! $dictionaryStacks->links('vendor.pagination.bulma') !!}

@endsection
