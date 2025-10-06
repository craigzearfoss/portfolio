@extends('admin.layouts.default', [
    'title' => 'Users',
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('guest.homepage') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Users' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New User', 'href' => route('admin.system.user.create') ],
        [ 'name' => '<i class="fa fa-list"></i> User Teams',   'href' => route('admin.system.user-team.index') ],
        [ 'name' => '<i class="fa fa-list"></i> User Groups',  'href' => route('admin.system.user-group.index') ],
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
                <th>user name</th>
                <th>name</th>
                <th>email</th>
                <th class="has-text-centered">verified</th>
                <th>status</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>user name</th>
                <th>name</th>
                <th>email</th>
                <th class="has-text-centered">verified</th>
                <th>status</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($users as $user)

                <tr data-id="{{ $user->id }}">
                    <td data-field="username">
                        {{ $user->username }}
                    </td>
                    <td data-field="name">
                        {{ $user->name }}
                    </td>
                    <td data-field="email">
                        {{ $user->email }}
                    </td>
                    <td data-field="email_verified_at" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $user->email_verified_at ])
                    </td>
                    <td data-field="status">
                        {{ \App\Models\User::statusName($user->status) }}
                    </td>
                    <td data-field=disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $user->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.system.user.destroy', $user->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.system.user.show', $user->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- show --}}
                            </a>

                            @if (!empty($user->link))
                                <a title="{{ !empty($user->link_name) ? $user->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $user->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- link --}}
                                </a>
                            @endif

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.system.user.edit', $user->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- edit --}}
                            </a>

                            <a title="change password" class="button is-small px-1 py-0"
                               href="{{ route('admin.system.user.change-password', $user->id) }}">
                                <i class="fa-solid fa-key"></i>{{-- change password --}}
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
                    <td colspan="7">There are no users.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $users->links('vendor.pagination.bulma') !!}

    </div>

@endsection
