@extends('admin.layouts.default', [
    'title' => 'Users',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Users']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New User', 'url' => route('admin.user.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th class="px-1">name</th>
            <th class="px-1">email</th>
            <th class="px-1 text-center">verified</th>
            <th class="px-1 text-center">status</th>
            <th class="px-1 text-center">disabled</th>
            <th class="px-1">actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th class="px-2">name</th>
            <th class="px-2">email</th>
            <th class="px-2 text-center">verified</th>
            <th class="px-2 text-center">status</th>
            <th class="px-2 text-center">disabled</th>
            <th class="px-2">actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($users as $user)

            <tr>
                <td class="py-0">
                    {{ $user->name }}
                </td>
                <td class="py-0">
                    {{ $user->email }}
                </td>
                <td class="py-0">
                    @include('admin.components.checkmark', [ 'checked' => $user->email_verified_at ])
                </td>
                <td class="py-0">
                    {{ \App\Models\User::statusName($user->status) }}
                </td>
                <td class="py-0">
                    @include('admin.components.checkmark', [ 'checked' => $user->disabled ])
                </td>
                <td class="white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.user.show', $user->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.user.edit', $user->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        <a title="change password" class="button is-small px-1 py-0"
                           href="{{ route('admin.user.change_password', $user->id) }}">
                            <i class="fa-solid fa-key"></i>{{-- Edit--}}
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
                <td colspan="6">There are no user stacks.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $users->links('vendor.pagination.bulma') !!}

@endsection
