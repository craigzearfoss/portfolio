@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left_ORIGINAL')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="h-full flex flex-auto flex-col justify-between ml-4 mr-4">

                    <h3 class="card-header">Messages</h3>

                    <div class="d-grid gap-2 d-md-flex justify-between">
                        <div>
                            @include('admin.components.messages', [$errors])
                        </div>
                        <div>
                            <?php /* <a class="btn btn-solid btn-sm" href="{{ route('admin.message.create') }}"><i class="fa fa-plus"></i> Add New Message</a> */ ?>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                        <tr>
                            <th></th>
                            <th>name</th>
                            <th>email</th>
                            <th>subject</th>
                            <th class="text-nowrap">created at</th>
                            <th class="text-nowrap">updated at</th>
                            <th>actions</th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse ($messages as $message)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->subject }}</td>
                                <td>{{ shortDateTime($message->created_at) }}</td>
                                <td>{{ shortDateTime($message->updated_at) }}</td>
                                <td class="text-nowrap">
                                    <form action="{{ route('admin.message.destroy', $message->id) }}" method="POST">
                                        <a class="btn btn-sm" href="{{ route('admin.message.show', $message->id) }}"><i
                                                    class="fa-solid fa-list"></i>{{-- Show--}}</a>
                                            <?php /*<a class="btn btn-sm" href="{{ route('admin.message.edit', $message->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a> */ ?>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm"><i
                                                    class="fa-solid fa-trash"></i>{{--  Delete--}}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">There are no messages.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                    {!! $messages->links() !!}

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
