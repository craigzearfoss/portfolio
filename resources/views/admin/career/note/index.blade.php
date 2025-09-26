@extends('admin.layouts.default', [
    'title' => 'Notes',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Notes' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Note', 'url' => route('admin.career.note.create') ],
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
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>subject</th>
                <th>created at</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>subject</th>
                <th>created at</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($notes as $note)

                <tr data-id="{{ $note->id }}">
                    @if(isRootAdmin())
                        <td data-field="admin.username">
                            @if(!empty($note->admin))
                                @include('admin.components.link', [
                                    'name' => $note->admin['username'],
                                    'url'  => route('admin.admin.show', $note->admin['id'])
                                ])
                            @endif
                        </td>
                    @endif
                    <td data-field="subject" style="white-space: nowrap;">
                        {{ $note->subject }}
                    </td>
                    <td data-field="created_at" style="white-space: nowrap;">
                        {{ shortDateTime($note->created_at) }}
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.note.destroy', $note->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.note.show', $note->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.note.edit', $note->id) }}">
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
                    <td colspan="{{ isRootAdmin() ? '4' : '3' }}">There are no notes.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $notes->links('vendor.pagination.bulma') !!}

    </div>

@endsection
