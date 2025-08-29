@extends('admin.layouts.default', [
    'title' => 'Communications',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Communications' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Communication', 'url' => route('admin.career.communication.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>subject</th>
            <th>created at</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>subject</th>
            <th>created at</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($communications as $communication)

            <tr>
                <td>
                    {{ $communication->subject }}
                </td>
                <td class="text-nowrap">
                    {{ shortDateTime($communication->created_at) }}
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.career.communication.destroy', $communication->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.career.communication.show', $communication->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.career.communication.edit', $communication->id) }}">
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
                <td colspan="3">There are no communications.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $communications->links('vendor.pagination.bulma') !!}

@endsection
