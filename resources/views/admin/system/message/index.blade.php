@extends('admin.layouts.default', [
    'title' => 'Message',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Messages' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Message', 'href' => route('admin.system.message.create') ],
    ],
    'errorMessages'=> $errors->any() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>email</th>
                <th>subject</th>
                <th>created at</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>email</th>
                <th>subject</th>
                <th>created at</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($messages as $message)

                <tr data-id="{{ $message->id }}">
                    <td data-field="name">
                        {{ $message->name }}
                    </td>
                    <td data-field="email">
                        {{ $message->email }}
                    </td>
                    <td data-field="subject">
                        {{ $message->subject }}
                    </td>
                    <td data-field="created_at">
                        {{ shortDateTime($message->created_at) }}
                    </td>
                    <td>
                        <form action="{{ route('admin.system.message.destroy', $message->id) }}" method="POST">
                            <a class="btn btn-sm" href="{{ route('admin.system.message.show', $message->id) }}"><i
                                    class="fa-solid fa-list"></i>{{-- Show --}}</a>
                                <?php /*<a class="btn btn-sm" href="{{ route('admin.system.message.edit', $message->id) }}"><i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}</a> */ ?>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm"><i
                                    class="fa-solid fa-trash"></i>{{-- Delete--}}</button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no messages.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $messages->links('vendor.pagination.bulma') !!}

    </div>

@endsection
