@php
$buttons = [];
if (canCreate('user', $admin)) {
    $buttons[] = view('admin.components.nav-button-add', ['name' => 'Add New User', 'href' => route('admin.system.user.create')])->render();
}
if (canRead('user-team', $admin)) {
    $buttons[] = view('admin.components.nav-button-view', ['name' => 'User Teams', 'href' => route('admin.system.user-team.index')])->render();
}
if (canRead('user-group', $admin)) {
    $buttons[] = view('admin.components.nav-button-view', ['name' => 'User Groups', 'href' => route('admin.system.user-group.index')])->render();
}
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Users',
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('home') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Users' ]
    ],
    'buttons'          => $buttons,
    'errorMessages'    => $errors->messages() ?? [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="card p-4">

        @if($pagination_top)
            {!! $users->links('vendor.pagination.bulma') !!}
        @endif

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

            @if(!empty($bottom_column_headings))
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
            @endif

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
                            'href' => route('admin.system.user-team.show', [$user, $user->team->id])
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
                    <td class="is-1">

                        <div class="action-button-panel">

                            @if(canRead($user, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.system.user.show', $user),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($user, $admin))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.system.user.edit', $user),
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

                            @if(canDelete($user, $admin))
                                <form class="delete-resource" action="{!! route('admin.system.user.destroy', $user) !!}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @include('admin.components.button-icon', [
                                        'title' => 'delete',
                                        'class' => 'delete-btn',
                                        'icon'  => 'fa-trash'
                                    ])
                                </form>
                            @endif

                        </div>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="8">There are no users.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        @if($pagination_bottom)
            {!! $users->links('vendor.pagination.bulma') !!}
        @endif

    </div>

@endsection
