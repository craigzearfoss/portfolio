@extends('admin.layouts.default', [
    'title' => 'References',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'References' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Reference', 'url' => route('admin.career.reference.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th class="text-center">primary</th>
            <th class="text-center">public</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th class="text-center">primary</th>
            <th class="text-center">public</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($references as $reference)

            <tr>
                <td>
                    {{ $reference->name }}
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $reference->primary ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $reference->public ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $reference->disabled ])
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.career.reference.destroy', $reference->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.career.reference.show', $reference->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.career.reference.edit', $reference->id) }}">
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
                <td colspan="5">There are no references.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $references->links('vendor.pagination.bulma') !!}

@endsection
