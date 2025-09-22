@extends('admin.layouts.default', [
    'title' => 'Message',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Message' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Message', 'url' => route('admin.message.create') ],
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
                <th class="text-nowrap">created at</th>
                <th class="text-nowrap">updated at</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>email</th>
                <th>subject</th>
                <th class="text-nowrap">created at</th>
                <th class="text-nowrap">updated at</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($messages as $message)

                <tr>
                    <td class="py-0">
                        {{ $message->name }}
                    </td>
                    <td class="py-0">
                        {{ $message->email }}
                    </td>
                    <td class="py-0">
                        {{ $message->subject }}
                    </td>
                    <td class="py-0">
                        {{ shortDateTime($message->created_at) }}
                    </td>
                    <td class="py-0">
                        {{ shortDateTime($message->updated_at) }}
                    </td>
                    <td class="py-0 text-nowrap">
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
                    <td colspan="6">There are no messages.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $messages->links('vendor.pagination.bulma') !!}

    </div>

@endsection
