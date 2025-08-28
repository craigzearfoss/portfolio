@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left_ORIGINAL')

            <div
                class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Notes</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <a class="btn btn-solid btn-sm" href="{{ route('admin.note.create') }}"><i
                                    class="fa fa-plus"></i> Add New Note</a>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>subject</th>
                            <th>body</th>
                            <th>created at</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($notes as $note)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $note->subject }}</td>
                                <td>{{ $note->body }}</td>
                                <td class="text-nowrap">{{ shortDateTime($note->created_at) }}</td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.note.destroy', $note->id) }}" method="POST">
                                        <a class="btn btn-sm" href="{{ route('admin.note.show', $note->id) }}"><i
                                                class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                        <a class="btn btn-sm" href="{{ route('admin.note.edit', $note->id) }}"><i
                                                class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i
                                                class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">There are no notes.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $notes->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
