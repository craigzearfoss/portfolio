@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $thisUser    = $thisUser ?? null;

    $title    = $pageTitle ?? 'User: ' . $thisUser->username;
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Users',           'href' => route('admin.system.user.index') ],
        [ 'name' => $thisUser->username ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($thisUser, $admin)) {
        $navButtons[] = view('admin.components.nav-button-change-password', [ 'name' => 'Change Password',
                                                                              'href' => route('admin.system.user.change-password', $thisUser)
                                                                            ])->render();
        $navButtons[] = view('admin.components.nav-button-edit', [ 'href' => route('admin.system.user.edit', $thisUser) ])->render();
    }
    if (canCreate($thisUser, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', [ 'name' => 'Add New User',
                                                               'href' => route('admin.system.user.create',
                                                                               $isRootAdmin ? [ 'owner_id' => $admin->id ] : []
                                                                              )
                                                             ])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', [ 'href' => referer('admin.system.user.index') ])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $thisUser->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'user name',
                'value' => $thisUser->username
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $thisUser->name
            ])

            @php
                $userTeamListItems = [];
                foreach ($thisUser->teams as $userTeam) {
                    $userTeamListItems[] = view('admin.components.link', [
                        'name' => $userTeam->name,
                        'href' => route('admin.system.user-team.show', $userTeam)
                    ]) . ($userTeam->id == $thisUser->team->id ? ' (current team)' : '');
                }
            @endphp
            @include('user.components.show-row', [
                'name'  => 'teams',
                'value' => !empty($userTeamListItems) ? implode('<br>', $userTeamListItems) : '',
            ])

            @php
                $userGroupListItems = [];
                foreach ($thisUser->groups as $userGroup) {
                    $userGroupListItems[] = view('admin.components.link', [
                        'name' => $userGroup->name,
                        'href' => route('admin.system.user-group.show', $userGroup)
                    ]) . (!empty($userGroup->team) ? ' (' . $userGroup->team->name . ')' : '');
                }
            @endphp
            @include('admin.components.show-row', [
                'name'  => 'groups',
                'value' => !empty($userGroupListItems) ? implode('<br>', $userGroupListItems) : '',
            ])

            @include('admin.components.show-row', [
                'name'  => 'salutation',
                'value' => $thisUser->salutation
            ])

            @include('admin.components.show-row', [
                'name'  => 'title',
                'value' => $thisUser->title
            ])

            @include('admin.components.show-row', [
                'name'  => 'role',
                'value' => $thisUser->role
            ])

            @include('admin.components.show-row', [
                'name'  => 'employer',
                'value' => $thisUser->employer
            ])

            @include('admin.components.show-row', [
                'name'  => 'location',
                'value' => formatLocation([
                               'street'          => $thisUser->street,
                               'street2'         => $thisUser->street2,
                               'city'            => $thisUser->city,
                               'state'           => $thisUser->state->code ?? '',
                               'zip'             => $thisUser->zip,
                               'country'         => $thisUser->country->iso_alpha3 ?? '',
                               'streetSeparator' => '<br>',
                           ])
            ])

            @include('admin.components.show-row-coordinates', [
                'resource' => $thisUser
            ])

            @include('admin.components.show-row', [
                'name'  => 'phone',
                'value' => $thisUser->phone
            ])

            @include('admin.components.show-row', [
                'name'  => 'email',
                'value' => $thisUser->email
            ])

            @include('admin.components.show-row', [
                'name'  => 'email verified at',
                'value' => longDateTime($thisUser->email_verified_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'birthday',
                'value' => longDate($thisUser->birthday),
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $thisUser->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $thisUser->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $thisUser->description
            ])

            @include('admin.components.show-row', [
                'name'  => 'bio',
                'value' => $thisUser->bio
            ])

            @include('admin.components.show-row-images', [
                'resource' => $thisUser,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row', [
                'name'  => 'status',
                'value' => \App\Models\System\User::statusName($thisUser->status) ?? ''
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $thisUser,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($thisUser->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($thisUser->updated_at)
            ])

        </div>
    </div>

@endsection
