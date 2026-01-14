@php
$buttons = [];
if (canCreate('user', getAdminId())) {
    $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New User', 'href' => route('root.user.create') ];
}
if (canRead('user', getAdminId())) {
    $buttons[] = [ 'name' => '<i class="fa fa-list"></i> User Teams', 'href' => route('root.user-team.index') ];
}
if (canRead('user', getAdminId())) {
    $buttons[] = [ 'name' => '<i class="fa fa-list"></i> User Groups', 'href' => route('root.user-group.index') ];
}
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Users',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('admin.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.index') ],
        [ 'name' => 'Users' ]
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'currentAdmin'  => $admin
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>user name</th>
                <th>name</th>
                <th>team</th>
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
                <th>team</th>
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
                        {!! $user->username !!}
                    </td>
                    <td data-field="name">
                        {!! $user->name !!}
                    </td>
                    <td data-field="user_team_id">
                        @include('user.components.link', [
                            'name' => $user->team->name,
                            'href' => route('admin.user-team.show', [$user, $user->team->id])
                        ])
                    </td>
                    <td data-field="email">
                        {!! $user->email !!}
                    </td>
                    <td data-field="email_verified_at" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $user->email_verified_at ])
                    </td>
                    <td data-field="status">
                        {!! \App\Models\System\User::statusName($user->status) ?? '' !!}
                    </td>
                    <td data-field=disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $user->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{!! route('root.user.destroy', $user->id) !!}" method="POST">

                            @if(canRead($user))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('root.user.show', $user->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($user))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('root.user.edit', $user->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($user->link))
                                @include('admin.components.link-icon', [
                                    'title'  => !empty($user->link_name) ? $user->link_name : 'link',
                                    'href'   => $user->link,
                                    'icon'   => 'fa-external-link',
                                    'target' => '_blank'
                                ])
                            @else
                                @include('admin.components.link-icon', [
                                    'title'    => 'link',
                                    'icon'     => 'fa-external-link',
                                    'disabled' => true
                                ])
                            @endif

                            @if(canDelete($user))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif

                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="8">There are no users.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $users->links('vendor.pagination.bulma') !!}

    </div>

@endsection
