@extends('admin.layouts.default', [
    'title' => 'Users',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Users' ]
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New User', 'url' => route('admin.user.create') ],
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
                <th>name</th>
                <th>email</th>
                <th class="has-text-centered">verified</th>
                <th>status</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>email</th>
                <th class="has-text-centered">verified</th>
                <th>status</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($users as $user)

                <tr>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $user->email_verified_at ])
                    </td>
                    <td>
                        {{ \App\Models\User::statusName($user->status) }}
                    </td>
                    <td class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $user->disabled ])
                    </td>
                    <td class="white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.user.show', $user->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show --}}
                            </a>

                            @if (!empty($user->link))
                                <a title="{{ !empty($user->link_name) ? $user->$project : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $user->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @endif

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.user.edit', $user->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            <a title="change password" class="button is-small px-1 py-0"
                               href="{{ route('admin.user.change-password', $user->id) }}">
                                <i class="fa-solid fa-key"></i>{{-- Change Password --}}
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
