@php
    $buttons = [];
    if (canUpdate($thisAdmin, $admin)) {
        $buttons[] = view('admin.components.nav-button', [ 'name' => 'Change Password',
                                                           'icon'=>'fa-key',
                                                           'href' => route('admin.system.admin.change-password', $thisAdmin)
                                                         ])->render();
        $buttons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.admin.edit', $thisAdmin) ])->render();
    }
    if (canCreate('admin', $admin)) {
        $buttons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New Admin',
                                                               'href' => route('admin.system.admin.create',
                                                                               $admin->root ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    $buttons[] = view('admin.components.nav-button-back', [ 'href' => route('admin.system.admin.index') ])->render();
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Admin: ' . $thisAdmin->name,
    'breadcrumbs'      => [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Admins',          'href' => route('admin.system.admin.index') ],
        [ 'name' => $thisAdmin->username ]
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

    <div class="show-container card p-4">

        <div style="display: inline-block; position: absolute; top: 0; right: 0;">
            @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
        </div>

        @include('admin.components.show-row', [
            'name'  => 'id',
            'value' => $thisAdmin->id
        ])

        @include('admin.components.show-row', [
            'name'  => 'user name',
            'value' => $thisAdmin->username
        ])

        @include('admin.components.show-row', [
            'name'  => 'name',
            'value' => $thisAdmin->name
        ])

        @php
            $adminTeamListItems = [];
            foreach ($thisAdmin->teams as $adminTeam) {
                $adminTeamListItems[] = view('admin.components.link', [
                    'name' => $adminTeam->name,
                    'href' => route('admin.system.admin-team.show', $adminTeam)
                ]) . ($adminTeam->id == $thisAdmin->team->id ? ' (current team)' : '');
            }
        @endphp
        @include('admin.components.show-row', [
            'name'  => 'teams',
            'value' => !empty($adminTeamListItems) ? implode('<br>', $adminTeamListItems) : '',
        ])

        @php
            $adminGroupListItems = [];
            foreach ($thisAdmin->groups as $adminGroup) {
                $adminGroupListItems[] = view('admin.components.link', [
                    'name' => $adminGroup->name,
                    'href' => route('admin.system.admin-group.show', $adminGroup)
                ]) . (!empty($adminGroup->team) ? ' (' . $adminGroup->team->name . ')' : '');
            }
        @endphp
        @include('admin.components.show-row', [
            'name'  => 'groups',
            'value' => !empty($adminGroupListItems) ? implode('<br>', $adminGroupListItems) : '',
        ])

        @include('admin.components.show-row', [
            'name'  => 'salutation',
            'value' => $thisAdmin->salutation
        ])

        @include('admin.components.show-row', [
            'name'  => 'title',
            'value' => $thisAdmin->title
        ])

        @include('admin.components.show-row', [
            'name'  => 'role',
            'value' => $thisAdmin->role
        ])

        @include('admin.components.show-row', [
            'name'  => 'employer',
            'value' => $thisAdmin->employer
        ])

        @include('admin.components.show-row', [
            'name'  => 'location',
            'value' => formatLocation([
                           'street'          => $thisAdmin->street,
                           'street2'         => $thisAdmin->street2,
                           'city'            => $thisAdmin->city,
                           'state'           => $thisAdmin->state->code ?? '',
                           'zip'             => $thisAdmin->zip,
                           'country'         => $thisAdmin->country->iso_alpha3 ?? '',
                           'streetSeparator' => '<br>',
                       ])
        ])

        @include('admin.components.show-row-coordinates', [
            'resource' => $thisAdmin
        ])

        @include('admin.components.show-row', [
            'name'  => 'phone',
            'value' => $thisAdmin->phone
        ])

        @include('admin.components.show-row', [
            'name'  => 'email',
            'value' => $thisAdmin->email
        ])

        @include('admin.components.show-row', [
            'name'  => 'email verified at',
            'value' => longDateTime($thisAdmin->email_verified_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'birthday',
            'value' => longDate($thisAdmin->birthday),
        ])

        @include('admin.components.show-row-link', [
            'name'   => !empty($thisAdmin->link_name) ? $thisAdmin->link_name : 'link',
            'href'   => $thisAdmin->link,
            'target' => '_blank'
        ])

        @include('admin.components.show-row', [
            'name'  => 'bio',
            'value' => $thisAdmin->bio
        ])

        @include('admin.components.show-row', [
            'name'  => 'description',
            'value' => $thisAdmin->description
        ])

        @include('admin.components.show-row-images', [
            'resource' => $thisAdmin,
            'download' => true,
            'external' => true,
        ])

        @include('admin.components.show-row', [
            'name'  => 'status',
            'value' => \App\Models\System\User::statusName($thisAdmin->status)
        ])

        @include('admin.components.show-row-settings', [
            'resource' => $thisAdmin,
        ])

        @include('admin.components.show-row-checkbox', [
            'name'    => 'requires re-login',
            'checked' => $thisAdmin->requires_relogin
        ])

        @include('admin.components.show-row', [
            'name'  => 'created at',
            'value' => longDateTime($thisAdmin->created_at)
        ])

        @include('admin.components.show-row', [
            'name'  => 'updated at',
            'value' => longDateTime($thisAdmin->updated_at)
        ])

    </div>

@endsection
